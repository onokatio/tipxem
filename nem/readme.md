# NEM関係のツール群

## 使う前にやること
`{thisdir}/Salt` 以下にどうにかして
[このライブラリ](https://github.com/devi/Salt) を設置すること。
## 使い方
### sha3.php
ただのsha3 (Keaccak) ライブラリ。

NEM用に古いKeccakに対応させてある。

第三引数にtrueを設定すると Binary String で返って来る。

そうでなければ Hex で返って来る。

[コレを使わせてもらった](https://github.com/0xbb/php-sha3)

```
require_once("./sha3.php");

echo Sha3::hash('', 512); //Sha3 hash (もともとあったやつ)
echo PHP_EOL;
echo Sha3::keccakhash('', 512); //Keccak hash (NEM用)
echo Sha3::keccakhash('', 512, true); //Binary String で返って来る
```

### NEM.php
NEM公式から持ってきた。NISに簡単にAPIのリクエストを投げられる。

[詳しくは公式ページで](https://github.com/NemProject/php2nem)
### KeyPair.php
秘密鍵からキーペアを生成します。

署名もできます。

new するときの秘密鍵は、

* Hex String ( 64文字, たまに先頭に00が付いている66文字のものがあるが自動で除去 )
* Binary String ( 32文字 )
* Byte Array ( 長さ 32 )

を受け付けます。

それ以外が渡された場合、各メソッド呼び出し時に false が返ります。
```
require_once("./KeyPair.php");

$kp = new KeyPair("b8afae6f4ad13a1b8aad047b488e0738a437c7389d4ff30c359ac068910c1d59");
echo $kp->getHexPrivate() . PHP_EOL; //e0be7ba79288832449b96cc259cc14e59509d88e6a97be1996dc71a153629d89
echo $kp->getHexPublic() . PHP_EOL; //7be68a839e3c5bd59a9b38c7a68ae2470aaff834bd2c12e1047d5ddc27596c11
echo $kp->getBinaryPrivate() . PHP_EOL; //Binary String な 秘密鍵
echo $kp->getBinaryPublic() . PHP_EOL; //Binary String な 公開鍵
echo $kp->sign("aa"); //1f9195b4d17665e414fdae46ad90b4eace85afde44ed572299da076022155baeb58db9afff27e7893d725798df798db3ff436b2a4e1974cb348eca4916e1210d

```

### TransacrionBuilder.php
配列からトランザクションのバイナリ、及びHex文字列を作ります。

**現在不完全 注意して使用すること**

feeは自動で計算されますが、指定するほうが良い。
```
require_once("./TransacrionBuilder.php");

$data = array(
  'type' => 0x101,
  'version' => 0x98000001,
  'signer' => '7be68a839e3c5bd59a9b38c7a68ae2470aaff834bd2c12e1047d5ddc27596c11',
  'recipient' => 'TB235JLAOGALDATDJC7LXDMZSDMFBUMDVIBFVQPF',
  'amount' => 1000 * 1000000,
  'fee' => 1 * 1000000,
  'message' => array( 'payload' => 'e697a5e69cace8aa9ee381aee381a6e38199e381a8', 'type' => 1),
  "timestamp" => timestamp2NEMTime(time()),
  "deadline" => timestamp2NEMTime(time()) + 2 * 60
);
$tx = new TransactionBuilder($data);
echo $tx->getBinary() . PHP_EOL;
echo $tx->getHex() . PHP_EOL;
```

### NEMUtil.php
ちょっとしたツール群

## 使用例
```
<?php
require_once("./KeyPair.php");
require_once("./TransactionBuilder.php");
require_once("./NEM.php");
require_once("./NEMUtil.php");
$conf = array('nis_address' => '192.3.61.243');
$nem = new NEM($conf);

$kp = new KeyPair("e0be7ba79288832449b96cc259cc14e59509d88e6a97be1996dc71a153629d89");
echo $kp->getHexPrivate() . PHP_EOL;
echo $kp->getHexPublic() . PHP_EOL;

$data = array(
  'type' => 0x101,
  'version' => 0x98000001,
  'signer' => '7be68a839e3c5bd59a9b38c7a68ae2470aaff834bd2c12e1047d5ddc27596c11',
  'recipient' => 'TB235JLAOGALDATDJC7LXDMZSDMFBUMDVIBFVQPF',
  'amount' => 1000 * 1000000,
  'fee' => 1 * 1000000,
  'message' => array( 'payload' => 'e697a5e69cace8aa9ee381aee381a6e38199e381a8', 'type' => 1),
  "timestamp" => timestamp2NEMTime(time()),
  "deadline" => timestamp2NEMTime(time()) + 2 * 60
);
$tx = new TransactionBuilder($data);

$signature = $kp->sign($tx->getBinary);

$res = $nem->nis_post('/transaction/announce', array("data" => $tx->getHex, "signature" => $signature));
echo $res;
```