<?php
	require __DIR__ . '/vendor/autoload.php'; //composerの自動ロード
	require 'key.php'; //TwitterAPIのdefine読み込み

	use mpyw\Co\Co; //名前空間を干渉しないようにするための設定
//	use mpyw\Co\CURLException;
	use mpyw\Cowitter\Client;
//	use mpyw\Cowitter\HttpException;

	define('MYNAME','@onoonokatio'); //ツイートの中から消すために、自分のツイッターIDを定義

	try {
		Co::wait(function () {


			$client = new Client([CK, CS, AT, ATS]); //API情報からクライアントオブジェクトを作成
			/*yield $client->streamingAsync('user', function ($status) { //ツイートを取得した時の動作
				if(strpos($status->text,MYNAME)===TRUE){
					$get = str_replace(array(MYNAME,"\n"),array('',' '),$status->text);
					if(strpos($get,' tip')!==false){
						echo "tipmode";
					}else if(strpos($get,' balance')!==false){
						//echo "your balance is 0!";
						//SELECT balance FROM tipxem.account WHERE uid == $uid;
					}else if(strpos($get,' deposit')!==false){
						//echo "depositmode";
						//SELECT adddres FROM tipxem.account WHERE uid == $uid;
					}
				}
			});*/
//			yield $task;
		var_dump($status);


		});
	} catch (RuntimeException $e) { //エラーが起こった時の情報を変数$eに入れる
		exit("Error: {$e->getMessage()}\n"); //エラーが起きたらメッセージを表示して終了
	}
?>
