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
