<?php
	require __DIR__ . '/vendor/autoload.php'; //composerの自動ロード
	require 'key.php'; //TwitterAPIのdefine読み込み todo パス設定

	use mpyw\Co\Co; //名前空間の設定
	use mpyw\Cowitter\Client;

	define('MYNAME','@onoonokatio'); //ツイートの中から消すために、自分のツイッターIDを定義

			$client = new Client([CK, CS, AT, ATS]); //API情報からクライアントオブジェクトを作成
			$tasks[] = $client->streamingAsync('user',function($status){ //ストリームにツイートが流れてくるたびに呼ばれる
				//var_dump($status);
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
			});

	try {
		Co::wait(function () {
			global $tasks;
			yield $tasks;
		});
	} catch (RuntimeException $e) { //エラーが起こった時の情報を変数$eに入れる
		exit("Error: {$e->getMessage()}"); //エラーが起きたらメッセージを表示して終了
		//todo これを例外にする
	}
?>
