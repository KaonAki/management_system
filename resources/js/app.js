import './bootstrap'

// ===================== 削除機能 ===================
// =================================================
$('.product-body').on('click', '.btn-delete', function () {
  console.log('ここまで接続されました！')
  let deleteConfirm = confirm('削除してよろしいでしょうか？')
  // メッセージをOKした時（true)の場合、次に進みます 
  if (deleteConfirm == true) {
    let clickEle = $(this)
    // $(this)は自身（今回は押されたボタンのinputタグ)を参照します
    // "clickEle"に対して、inputタグの設定が全て代入されます

    let productId = clickEle.attr('data-product_id')
    // attr()」は、HTML要素の属性を取得したり設定することができるメソッドです
    // 今回はinputタグの"data-user_id"という属性の値を取得します
    // "data-user_id"にはレコードの"id"が設定されているので
    // 削除するレコードを指定するためのidの値をここで取得します

    $.ajax({
      type: 'POST',
      url: '/destroy/' + productId, // productId にはレコードのIDが代入されています
      dataType: 'json',
      data: {'id': productId},
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    })
      .done(function () {
        // 通信が成功した場合、クリックした要素の親要素の <tr> を削除
        console.log('done')
        clickEle.parents('tr').remove()
      })
      .fail(function () {
        alert('エラー')
      })
    console.log('ここまで接続されました！')
  // ”削除しても良いですか”のメッセージで”いいえ”を選択すると次に進み処理がキャンセルされます
  } else {
    alert('削除中止いたしました。')
    ;(function (e) {
      e.preventDefault()
    })
  }
})

// ================= 一覧表示のajax ==================
// ==================================================

$(function () {
  $('#myTable').tablesorter() // これでソート機能追加
  $('.product-body').empty(); // もともとある要素を空にする

  $.ajax({
    type: 'get',
    url: '/ajax',
    dataType: 'json'
  }).done(function (data) {
    let html = ''
    $.each(data, function (index, value) { // dataの中身からvalueを取り出す
      // ここの記述はリファクタ可能
      let product_id = value.id
      let product_name = value.product_name
      let product_price = value.price
      let product_stock = value.stock
      let product_img_path = value.img_path
      let product_company_name = value.company_name
      // console.log(value)

      html = `
      <tr class="product-sasasa">
      <td><img src="/storage/images/${product_img_path}"></td>
        <td><p>${product_name}</p></td>
        <td><p>¥${product_price}</p></td>
        <td><p>在庫数:${product_stock }</p></td>
        <td><p>メーカー:${product_company_name}</p></td>
        <td><a href="{{ route('detailProduct', $product->id) }}">
      <button class="me-3 detail btn btn-success">詳細</button>
  </a></td>

  <td>
          <input data-product_id="${product_id}" type="button" class="btn btn-danger btn-delete" value="削除">
  </td>
      </tr>  
            `
      $('.product-body').append(html); // できあがったテンプレートをビューに追加
      $('#myTable').trigger('update') // これでソート機能追加
    })
  })
    .fail(function (data) {
      console.log('error')
    })
})

// ================== キーワード検索のajax ==================
// =======================================================
$('.search-form .search-icon').on('click', function () {
  $('#myTable').tablesorter() // これでソート機能追加
  $('.product-body').empty(); // もともとある要素を空にする

  let productName = $('#search_name').val(); // 検索ワードを取得

  if (!productName) {
    return false
  } // ガード節で検索ワードが空の時、ここで処理を止めて何もビューに出さない

  $.ajax({
    type: 'get',
    url: '/products/' + productName, // web.phpのURLと同じ形にする
    dataType: 'json', // json形式で受け取る
    data: {
      'search_name': productName // ここはコントローラーに贈りたい情報。今回は検索フォームのバリューを送りたい。
    }

  }).done(function (data) { // ajaxが成功したときの処理
    let html = ''
    $.each(data, function (index, value) { // dataの中身からvalueを取り出す
      // ここの記述はリファクタ可能
      let product_name = value.product_name
      let product_price = value.price
      let product_stock = value.stock
      let product_img_path = value.img_path
      let product_company_name = value.company_name
      // console.log(value)

      html = `
      <tr>
      <td><img src="/storage/images/${product_img_path}"></td>
        <td><p>${product_name}</p></td>
        <td><p>¥${product_price}</p></td>
        <td><p>在庫数:${product_stock }</p></td>
        <td><p>メーカー:${product_company_name}</p></td>
        <td><a href="{{ route('detailProduct', $product->id) }}">
      <button class="me-3 detail btn btn-success">詳細</button>
  </a></td>

  <td>
      <form action="{{ route('deleteProduct', $product->id) }}" method="POST"
          onclick='return confirm("「{{ $product->product_name }}」を削除しますか？")'>
          
          <button type="submit" class="btn btn-danger ">削除</button>
      </form>
  </td>
      </tr>  
            `
      $('.product-body').append(html); // できあがったテンプレートをビューに追加
      $('#myTable').trigger('update') // これでソート機能追加
    })
    // 検索結果がなかったときの処理
    if (data.length === 0 || data.length == '') {
      $('.search-form').after('<p class="text-center mt-5 search-null">ユーザーが見つかりません</p>')
    }
  }).fail(function () {
    // ajax通信がエラーのときの処理
    console.log('どんまい！')
  })
})

// ===================== 会社の検索ajax ====================
// =======================================================
$('.searchCompany-form .searchCompany-icon').on('click', function () {
  $('#myTable').tablesorter() // これでソート機能追加
  $('.product-body').empty(); // もともとある要素を空にする

  let companyName = $('#company_name').val(); // idがあるとこのvalueを取得

  if (!companyName) {
    return false
  } // ガード節で検索ワードが空の時、ここで処理を止めて何もビューに出さない

  $.ajax({
    type: 'get',
    url: '/seachCompany/' + companyName, // web.phpのURLと同じ形にする
    dataType: 'json', // json形式で受け取る
    data: {
      'company_name': companyName // ここはコントローラーに贈りたい情報。今回は検索フォームのバリューを送りたい。
    }

  }).done(function (data) { // ajaxが成功したときの処理
    let html = ''
    $.each(data, function (index, value) { // dataの中身からvalueを取り出す
      // ここの記述はリファクタ可能
      let product_name = value.product_name
      let product_price = value.price
      let product_stock = value.stock
      let product_img_path = value.img_path
      let product_company_name = value.company_name

      html = `
      <tr>
      <td><img src="/storage/images/${product_img_path}"></td>
        <td><p>${product_name}</p></td>
        <td><p>¥${product_price}</p></td>
        <td><p>在庫数:${product_stock }</p></td>
        <td><p>メーカー:${product_company_name}</p></td>
        <td><a href="{{ route('detailProduct', $product->id) }}">
      <button class="me-3 detail btn btn-success">詳細</button>
  </a></td>

  <td>
      <form action="{{ route('deleteProduct', $product->id) }}" method="POST"
          onclick='return confirm("「{{ $product->product_name }}」を削除しますか？")'>
          
          <button type="submit" class="btn btn-danger ">削除</button>
      </form>
  </td>
      </tr>  
      `

      $('.product-body').append(html); // できあがったテンプレートをビューに追加
      $('#myTable').trigger('update') // これでソート機能追加
    })
    // 検索結果がなかったときの処理
    if (data.length === 0 || data.length == '') {
      $('.search-form').after('<p class="text-center mt-5 search-null">ユーザーが見つかりません</p>')
    }
  }).fail(function () {
    // ajax通信がエラーのときの処理
    console.log('どんまい！')
  })
})

// ===================== 価格検索ajax =====================
// =======================================================
$('.search-price-form .search-price-icon').on('click', function () {
  $('#myTable').tablesorter() // これでソート機能追加
  $('.product-body').empty(); // もともとある要素を空にする
  console.log('開始！')
  let productPrice = $('#product_price').val(); // idがあるとこのvalueを取得

  if (!productPrice) {
    return false
  } // ガード節で検索ワードが空の時、ここで処理を止めて何もビューに出さない

  $.ajax({
    type: 'get',
    url: '/seachPrice/' + productPrice, // web.phpのURLと同じ形にする
    dataType: 'json', // json形式で受け取る
    data: {
      'product_price': productPrice // ここはコントローラーに贈りたい情報。今回は検索フォームのバリューを送りたい。
    }

  }).done(function (data) { // ajaxが成功したときの処理
    let html = ''
    $.each(data, function (index, value) { // dataの中身からvalueを取り出す
      // ここの記述はリファクタ可能
      let product_name = value.product_name
      let product_price = value.price
      let product_stock = value.stock
      let product_img_path = value.img_path
      let product_company_name = value.company_name

      html = `
      <tr>
      <td><img src="/storage/images/${product_img_path}"></td>
        <td><p>${product_name}</p></td>
        <td><p>¥${product_price}</p></td>
        <td><p>在庫数:${product_stock }</p></td>
        <td><p>メーカー:${product_company_name}</p></td>
        <td><a href="{{ route('detailProduct', $product->id) }}">
      <button class="me-3 detail btn btn-success">詳細</button>
  </a></td>

  <td>
      <form action="{{ route('deleteProduct', $product->id) }}" method="POST"
          onclick='return confirm("「{{ $product->product_name }}」を削除しますか？")'>
          
          <button type="submit" class="btn btn-danger ">削除</button>
      </form>
  </td>
      </tr>  
      `

      $('.product-body').append(html); // できあがったテンプレートをビューに追加
      $('#myTable').trigger('update') // これでソート機能追加
    })
    // 検索結果がなかったときの処理
    if (data.length === 0 || data.length == '') {
      $('.search-form').after('<p class="text-center mt-5 search-null">ユーザーが見つかりません</p>')
    }
  }).fail(function () {
    // ajax通信がエラーのときの処理
    console.log('どんまい！')
  })
})

// ===================== 在庫検索ajax =====================
// ======================================================
$('.search-stock-form .search-stock-icon').on('click', function () {
  $('#myTable').tablesorter() // これでソート機能追加
  $('.product-body').empty(); // もともとある要素を空にする
  console.log('開始！')
  let productStock = $('#product_stock').val(); // idがあるとこのvalueを取得

  if (!productStock) {
    return false
  } // ガード節で検索ワードが空の時、ここで処理を止めて何もビューに出さない

  $.ajax({
    type: 'get',
    url: '/seachStock/' + productStock, // web.phpのURLと同じ形にする
    dataType: 'json', // json形式で受け取る
    data: {
      'product_stock': productStock // ここはコントローラーに贈りたい情報。今回は検索フォームのバリューを送りたい。
    }

  }).done(function (data) { // ajaxが成功したときの処理
    let html = ''
    $.each(data, function (index, value) { // dataの中身からvalueを取り出す
      // ここの記述はリファクタ可能
      let product_name = value.product_name
      let product_price = value.price
      let product_stock = value.stock
      let product_img_path = value.img_path
      let product_company_name = value.company_name

      html = `
      <tr>
      <td><img src="/storage/images/${product_img_path}"></td>
        <td><p>${product_name}</p></td>
        <td><p>¥${product_price}</p></td>
        <td><p>在庫数:${product_stock }</p></td>
        <td><p>メーカー:${product_company_name}</p></td>
        <td><a href="{{ route('detailProduct', $product->id) }}">
      <button class="me-3 detail btn btn-success">詳細</button>
  </a></td>

  <td>
      <form action="{{ route('deleteProduct', $product->id) }}" method="POST"
          onclick='return confirm("「{{ $product->product_name }}」を削除しますか？")'>
          
          <button type="submit" class="btn btn-danger ">削除</button>
      </form>
  </td>
      </tr>  
      `

      $('.product-body').append(html); // できあがったテンプレートをビューに追加
      $('#myTable').trigger('update') // これでソート機能追加
    })
    // 検索結果がなかったときの処理
    if (data.length === 0 || data.length == '') {
      $('.search-form').after('<p class="text-center mt-5 search-null">ユーザーが見つかりません</p>')
    }
  }).fail(function () {
    // ajax通信がエラーのときの処理
    console.log('どんまい！')
  })
})
