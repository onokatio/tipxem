# NIS APIの返す情報
## 履歴 history
```
{
  "meta": {
    "innerHash": {},
    "id": 609086,
    "hash": {
      "data": "869a506b9347a9eaec5b398cd2270883e2d0f5157187c9e8ba10d17c4534af91"
    },
    "height": 880993
  },
  "transaction": {
    "timeStamp": 53365874,
    "amount": 1000000,
    "signature": "6f4335d1dc0bf3ba3fb162ccfd4a5f10cc691937fdf98fe61dd67456df7bbedb02c80269f9867cac22a3994959638bfa2647af0d4a8dc53b888358e67033ee0b",
    "fee": 1000000,
    "recipient": "NAUFIPHWAAFJWLE5C33WW36SI5BVDV32ODLFDFBK",
    "mosaics": [
      {
        "quantity": 1,
        "mosaicId": {
          "namespaceId": "tanukinakamoto",
          "name": "medal"
        }
      }
    ],
    "type": 257,
    "deadline": 53452274,
    "message": {},
    "version": 1744830466,
    "signer": "90f518c80e8c79691aab4de6c722d20201da184dd064142f10ad88316d7aaf8f"
  }
}
```
tipxemを作るうえで重要なものは太字にしてある。

|パラメータ名|解説|
|:---|:---|
|innerHash|multisig時に署名対象のトランザクションハッシュが入る|
|**id**|トランザクション固有のID 履歴取得時に範囲を指定するとき等に必要|
|hash.data|トランザクションハッシュ|
|height|取り込まれたブロック|
|**timeStamp**|トランザクションが作成された日時(NEM Timestamp)|
|**amount**|金額。mosaic送金の場合は倍率。(micro XEM)|
|signature|このトランザクションの署名|
|**fee**|このトランザクションに掛かった手数料(micro XEM)|
|**recipient**|受取人・送金先(micro XEM)|
|type|このトランザクションの種類|
|deadline|このトランザクションの期限。これまでに承認されなければキャンセルされる。(NEM Timestamp)|
|**message**|このトランザクションに添付されたメッセージ。なければからオブジェクト。|
|**message.payload**|メッセージ本文。hexなので2文字ずつバイト配列として読み込みUTF8で解釈する。|
|**message.type**|メッセージ種類。1ならプレーンテキスト、2なら暗号化されたテキスト。|
|version|ネットワークバージョン。NEMのmainnetなら1744830466で、testnetやmijinだと変わる|
|**signer**|送金者、つまりこのトランザクションの作成者のパブリックキー。これからアドレスを生成できる。|
|mosics|mosaicが含まれるとこれが出現|
|mosics.quanty|送金されたmosaic量|
|mosics.mosaicId.namespaceId|そのmosaicが所属するnamespace|
|mosics.mosaicId.name|そのmosaicの名前|

DBに最低限保存すべき情報
+ id   より昔の履歴を取得したり、未確認履歴がもうないことを確認するときに使用
+ timeStamp
+ amount   当たり前
