# tipxem

##これはなにか

[Twitter](https://twitter.com)上でツイート一つで、NEMのモザイク「XEM」を送受金できるように作られたBOT。

##必要なもの
composerが入った環境で、

```
$ composer install
```
とコマンドをうち必要なライブラリを取り寄せる。

またNEM用にSaltライブラリを導入（詳しくはNEM/Readme.mdを参照

次に、このREADME.mdが置いてあるのと同じ階層に、以下を例に、Twitter操作用のAPIキーの設定ファイルをkey.phpという名前で置く。

```
	<?php
		define('AT','アクセストークン');
		define('ATS','アクセストークンシークレット');
		define('CK','カスタマーキー');
		define('CS','カスタマーシークレット');
	?>
```
APIキーを取得するには[ここ](https://apps.twitter.com/)
