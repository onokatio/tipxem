<?php
	require __DIR__ . '/vendor/autoload.php'; //composerの自動ロード
	require __DIR__ . '/key.php'; //TwitterAPIのdefine読み込み todo パス設定

	use mpyw\Co\Co; //名前空間の設定
	use mpyw\Cowitter\Client;

	define('MYNAME','@onoonokatio'); //ツイートの中から消すために、自分のツイッターIDを定義

	Co::wait(function () {


			$client = new Client([CK, CS, AT, ATS]); //API情報からクライアントオブジェクトを作成
			yield $client->streamingAsync('user',function($status) use ($client){ //ストリームにツイートが流れてくるたびに呼ばれる
//				var_dump($status);
//				exit();
				if( isset($status->text) && strpos($status->text,MYNAME)!==FALSE){
					$get = str_replace(array(MYNAME,"\n"),array('',' '),$status->text);
					if(strpos($get,' tip ')!==false){
						$get = str_replace(' tip ','',$get);
						$get = explode(' ',$get,3);
						yield Co::SAFE => $client->postAsync('statuses/update',['status' => "@{$status->user->screen_name} さんの{$get[1]}XEMを{$get[0]}さんにばびゅん！" ,'in_reply_to_status_id' => $status->id]);
					}else if(strpos($get,' balance')!==false){
						yield Co::SAFE => $client->postAsync('statuses/update',['status' => "@{$status->user->screen_name} さんの残高は0XEMですよっ！" ,'in_reply_to_status_id' => $status->id]);
						//SELECT balance FROM tipxem.account WHERE uid == $uid;
					}else if(strpos($get,' deposit')!==false){
						yield Co::SAFE => $client->postAsync('statuses/update',['status' => "@{$status->user->screen_name} さんのアドレスは…残念ながらまだ作ってないです！開発者あくしろよっw！！" ,'in_reply_to_status_id' => $status->id]);
						//SELECT adddres FROM tipxem.account WHERE uid == $uid;
					}else if(strpos($get,' withdraw')!==false){
						$get = str_replace(' withdraw ','',$get);
						$get = explode(' ',$get,2);
						yield Co::SAFE => $client->postAsync('statuses/update',['status' => "@{$status->user->screen_name} さんの{$get[1]}XEMを{$get[0]}にぶん投げたよ！" ,'in_reply_to_status_id' => $status->id]);
					}
				}
			});
		});
/*	} catch (RuntimeException $e) { //エラーが起こった時の情報を変数$eに入れる
		exit("Error: {$e->getMessage()}"); //エラーが起きたらメッセージを表示して終了
		//todo これを例外にする
	}*/
?>
