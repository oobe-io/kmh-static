document.addEventListener("DOMContentLoaded", function () {
  if (pdf_url_latest !== undefined) {
    let element = document.getElementById("pdf");
    if (element != null) {
      element.href = pdf_url_latest.trim();
    }
  }
/*
  const pdfLinkElement = document.getElementById("pdf");
  // 指定したファイルを取得
  fetch(filePath)
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTPエラー! ステータス: ${response.status}`);
      }
      return response.url; // ファイルが存在するならば、そのURLを返す
    })
    .then(url => {
      pdfLinkElement.href = url.trim(); // href属性に取得したURLを設定
    })
    .catch(error => {
      console.error('PDF URLの読み込み中にエラーが発生しました:', error);
    });
*/
});