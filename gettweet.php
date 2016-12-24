<?php
	require __DIR__ . '/vendor/autoload.php'; //composerの自動ロード
	require __DIR__ . '/key.php'; //TwitterAPIのdefine読み込み todo パス設定

	use mpyw\Co\Co; //名前空間の設定
	use mpyw\Cowitter\Client;

	define('MYNAME','@onoonokatio'); //ツイートの中から消すために、自分のツイッターIDを定義

	Co::wait(function () {


			$client = new Client([CK, CS, AT, ATS]); //API情報からクライアントオブジェクトを作成
			yield $client->streamingAsync('user',function($status) use ($client){ //ストリームにツイートが流れてくるたびに呼ばれる
				var_dump($status);
				if( isset($status->text) && strpos($status->text,MYNAME)!==FALSE){ //それが自分宛のツイートだった時
					$get = str_replace(array(MYNAME,"\n"),array('',' '),$status->text); //とりあえず自分の名前を消す

					if(strpos($get,' tip ')!==false){ //tipの文字が含まれていたら
						$get = str_replace(' tip ','',$get); //tipを消す
						$get = explode(' ',$get,3); //配列に押し込む
						if(ctype_digit($get[1]) && $get[0][0] == '@'){ //ユーザー名に@入ってて、さらに量が文字ならば
							//ツイートする
							yield Co::SAFE => $client->postAsync('statuses/update',['status' => "@{$status->user->screen_name} さんの{$get[1]}XEMを{$get[0]}さんにばびゅん！" ,'in_reply_to_status_id' => $status->id]);
							yield Co::SAFE => $client->postAsync('favorites/create',['id' => $status->id]);
						}else{
							//ふえぇ
							yield Co::SAFE => $client->postAsync('statuses/update',['status' => "ふえぇ…なにゆってるかわからないよぉ…" ,'in_reply_to_status_id' => $status->id]);						
						}

					}else if(strpos($get,' withdraw')!==false){
						$get = str_replace(' withdraw ','',$get);
						$get = explode(' ',$get,3);
						if(ctype_digit($get[1])){
							yield Co::SAFE => $client->postAsync('statuses/update',['status' => "@{$status->user->screen_name} さんの{$get[1]}XEMを{$get[0]}にぶん投げたよ！" ,'in_reply_to_status_id' => $status->id]);
							yield Co::SAFE => $client->postAsync('favorites/create',['id' => $status->id]);
						}else{
							yield Co::SAFE => $client->postAsync('statuses/update',['status' => "ふえぇ…なにゆってるかわからないよぉ…" ,'in_reply_to_status_id' => $status->id]);						
						}

					}else if(strpos($get,' balance')!==false){
						yield Co::SAFE => $client->postAsync('statuses/update',['status' => "@{$status->user->screen_name} さんの残高は0XEMですよっ！" ,'in_reply_to_status_id' => $status->id]);
						yield Co::SAFE => $client->postAsync('favorites/create',['id' => $status->id]);
						//SELECT balance FROM tipxem.account WHERE uid == $uid;

					}else if(strpos($get,' deposit')!==false){
						yield Co::SAFE => $client->postAsync('statuses/update',['status' => "@{$status->user->screen_name} さんのアドレスは…残念ながらまだ作ってないです！開発者あくしろよっw！！" ,'in_reply_to_status_id' => $status->id]);
						//SELECT adddres FROM tipxem.account WHERE uid == $uid;
					}
				}
			});
		});
/*	} catch (RuntimeException $e) { //エラーが起こった時の情報を変数$eに入れる
		exit("Error: {$e->getMessage()}"); //エラーが起きたらメッセージを表示して終了
		//todo これを例外にする
	}*/
?>
