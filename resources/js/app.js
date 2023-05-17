import './bootstrap'

// $('.search-form .search-icon').on('click', function () {
//   $('.product-table').empty(); // もともとある要素を空にする
//   // $('.search-null').remove(); //検索結果が0のときのテキストを消す

//   let productName = $('#search_name').val(); // 検索ワードを取得
//   console.log(productName + 'どう？')

//   if (!productName) {
//     return false
//   } // ガード節で検索ワードが空の時、ここで処理を止めて何もビューに出さない

//   $.ajax({
//     type: 'get',
//     url: '/products', // web.phpのURLと同じ形にする
//     dataType: 'json', // json形式で受け取る
//     data: {
//       'product_name': productName // ここはサーバーに贈りたい情報。今回は検索フォームのバリューを送りたい。
//     }

//   }).done(function (data) { // ajaxが成功したときの処理
//     console(data)
//     let html = ''
//     $.each(data, function (index, value) { // dataの中身からvalueを取り出す
//       // ここの記述はリファクタ可能
//       let id = value.id
//       let name = value.name
//       let avatar = value.avatar
//       let itemsCount = value.items_count
//       // １ユーザー情報のビューテンプレートを作成
//       html = `
//                      <p>できました。</p>
//                               `
//     })
//     $('.user-table tbody').append(html); // できあがったテンプレートをビューに追加
//     // 検索結果がなかったときの処理
//     if (data.length === 0) {
//       $('.user-index-wrapper').after('<p class="text-center mt-5 search-null">ユーザーが見つかりません</p>')
//     }
//   }).fail(function () {
//     // ajax通信がエラーのときの処理
//     console.log('どんまい！')
//   })
// })
