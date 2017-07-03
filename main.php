<?php
// onokatio@gmail.com


	require __DIR__ . '/vendor/autoload.php';
	require __DIR__ . '/key.php';

	use mpyw\Co\Co;
	use mpyw\Cowitter\Client;

	define('MYNAME','@tip_xem'); //ツイートの中から消すために、自分のツイッターIDを定義
	define('DEBUG',TRUE); //ツイートの中から消すために、自分のツイッターIDを定義

	function decode($tweet){ //ツイートの整形
		// 半角空白、全角空白を統一
		// 連続した空白をまとめる
		// 空白区切りで配列に変換
		//return $tweet
		//$tweet->text = 整形した配列
		//$tweet->id = ツイートのID(リプライ等のため)
	}
	
	function tweet($text,$reply){ //ツイートの実行ラッパー
		//
	}
	
	function fav($id){ //ツイートのファボ
		//
	}

	function tip($get){
		/*$get = str_replace(' tip ','',$get); //tipを消す
		$get = explode(' ',$get,3); //配列に押し込む
		if(ctype_digit($get[1]) && $get[0][0] == '@'){ //ユーザー名に@入ってて、さらに量が数値ならば
			yield Co::SAFE => $client->postAsync('statuses/update',['status' => "@{$status->user->screen_name} さんの{$get[1]}XEMを{$get[0]}さんにばびゅん！" ,'in_reply_to_status_id' => $status->id]);
		}else{
			yield Co::SAFE => $client->postAsync('statuses/update',['status' => "ふえぇ…なにゆってるかわからないよぉ…" ,'in_reply_to_status_id' => $status->id]);						
		}*/
		
		// 引数の三番目の引数と四番目の引数を使用する
		// 三番目が@が付いているかの調査
		// 三番目のツイッターアカウントに紐づくウォレットのアカウントが存在するか
		//   しないなら保管
		//   するならデータベースにバッファ
	}
	function dototweet($status,$client){
		var_dump($status);
		if( isset($status->text) && strpos($status->text,MYNAME)!==FALSE){
			$status->text = str_replace(MYNAME,null,$status->text);
			$status->
			$status->text = str_replace("\n",null,$status->text);

			if(strpos($status->text,' tip ')!==false){
				tip($status->text);
			}else if(strpos($get,' withdraw')!==false){
				$get = str_replace(' withdraw ','',$get);
				$get = explode(' ',$get,3);
				if(ctype_digit($get[1])){
					yield Co::SAFE => $client->postAsync('statuses/update',['status' => "@{$status->user->screen_name} さんの{$get[1]}XEMを{$get[0]}にぶん投げたよ！" ,'in_reply_to_status_id' => $status->id]);
				}else{
					yield Co::SAFE => $client->postAsync('statuses/update',['status' => "ふえぇ…なにゆってるかわからないよぉ…" ,'in_reply_to_status_id' => $status->id]);						
				}
			}else if(strpos($get,' balance')!==false){
				yield Co::SAFE => $client->postAsync('statuses/update',['status' => "@{$status->user->screen_name} さんの残高は0XEMですよっ！" ,'in_reply_to_status_id' => $status->id]);
						//SELECT balance FROM tipxem.account WHERE uid == $uid;
			}else if(strpos($get,' deposit')!==false){
				yield Co::SAFE => $client->postAsync('statuses/update',['status' => "@{$status->user->screen_name} さんのアドレスは…残念ながらまだ作ってないです！開発者あくしろよっw！！" ,'in_reply_to_status_id' => $status->id]);
						//SELECT adddres FROM tipxem.account WHERE uid == $uid;
			}else{
			}
			yield Co::SAFE => $client->postAsync('favorites/create',['id' => $status->id]);
		}
	}

	Co::wait(function () {
			$client = new Client([CK, CS, AT, ATS]); //API情報からクライアントオブジェクトを作成
			yield $client->streamingAsync('user',function($status) use($client){
				dototweet($status,$client);
			});//ストリームにツイートが流れてくるたびにdototweet呼ばれる
	});
?>

