export const json = {
  "pages": [
    {
      "name": "parentInfo",
      "title": "保護者情報",
      "elements": [
        {
          "type": "text",
          "name": "parentName",
          "title": "保護者氏名",
          "isRequired": true
        },
        {
          "type": "text",
          "name": "parentNameKana",
          "title": "保護者氏名（カナ）",
          "isRequired": true
        },
        {
          "type": "text",
          "name": "email",
          "title": "メールアドレス",
          "inputType": "email",
          "isRequired": true
        },
        {
          "type": "text",
          "name": "tel",
          "title": "電話番号（ハイフンなし）",
          "inputType": "tel",
          "isRequired": true
        },
        {
          "type": "text",
          "name": "password",
          "title": "パスワード（8桁の半角英数字）",
          "inputType": "password",
          "isRequired": true
        },
        {
          "type": "text",
          "name": "passwordConfirm",
          "title": "パスワード（確認用）",
          "inputType": "password",
          "isRequired": true
        },
        {
          "type": "text",
          "name": "postCode",
          "title": "郵便番号（ハイフンなし）",
          "isRequired": true
        },
        {
          "type": "text",
          "name": "address",
          "title": "住所",
          "isRequired": true
        },
        {
          "type": "text",
          "name": "introduction",
          "title": "紹介先"
        },
        {
          "type": "comment",
          "name": "consaltation",
          "title": "相談内容"
        },
      ]
    },
    {
      "name": "childInfo",
      "title": "利用児情報",
      "elements": [
        {
          "type": "matrixdynamic",
          "name": "children",
          "title": "利用児情報を入力してください（兄弟児がいる場合は追加してください）",
          "addRowText": "兄弟児を追加",
          "removeRowText": "削除",
          "rowCount": 1,
          "minRowCount": 1,
          "columns": [
            { "name": "childName", "title": "利用児氏名", "cellType": "text", "isRequired": true },
            { "name": "childNameKana", "title": "利用児氏名（カナ）", "cellType": "text", "isRequired": true },
            { "name": "childBirthDate", "title": "生年月日", "cellType": "text", "inputType": "date", "isRequired": true },
            { "name": "gender", "title": "性別", "cellType": "dropdown", "choices": [ "男の子", "女の子" ], "isRequired": true },
            { "name": "diagnosis", "title": "診断名", "cellType": "text" }
          ]
        }
      ]
    }
  ],
  "showProgressBar": "top",
  "title": "新規登録"
};