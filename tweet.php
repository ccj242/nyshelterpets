<?php
/**/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$d = file_get_contents('data');
$d= json_decode($d);


$count=500;

$emojis=[😋,😀,❤️,💛,💚,💙,💜,😍,😊,☺️,😇,🆘,🚨];

$hashtags=[
'#Rescue',
'#adoptdontshop',
'#Foster',
'#PetRescue',
'#Adoption',
'#PetAdoption',
'#AnimalLove',
'#AdoptMe',
'#savealife',
'#adoptdontshop'
];

$hashtagtwo=[
'#spca',
'#NYC',
'#petlovers',
'#urgent'];
echo "boooom";
if (rand(0,10)>6){
	$petemoji=[😺,😸,😹,😻,😽];
	array_push($hashtagtwo,'#catsoftwitter,#catlovers','#catlover','#cats');
$response = file_get_contents("http://api.petfinder.com/pet.find?format=json&key=*/Your_API_Key*/&callback=?&count=".$count."&animal=cat&location=10001");
}else{
	$petemoji=[🐕,🐾,🐶];
	array_push($hashtagtwo,'#dogsoftwitter','#rescuedogs','#doglovers','#puppylove','#dogs');
$response = file_get_contents("http://api.petfinder.com/pet.find?format=json&key=*/Your_API_Key*/&callback=?&count=".$count."&animal=dog&location=10001");
}


$response=str_replace('$t','param',$response);

$response=substr($response, 2);
$response=substr($response, 0, -2);
$response=json_decode($response);


for ($i=0;$i<$count;$i++){

if (isset($response->petfinder->pets->pet[0]->media->photos->photo[2])){

if (!in_array((string)$response->petfinder->pets->pet[$i]->id->param,$d)){

if (isset($tempi)){

if (strtotime($response->petfinder->pets->pet[$i]->lastUpdate->param)<$lowestdate){
$tempi=$i;
$lowestdate=strtotime($response->petfinder->pets->pet[$i]->lastUpdate->param);
}

}else{
$tempi=$i;
$lowestdate=strtotime($response->petfinder->pets->pet[$i]->lastUpdate->param);

}
}
}
}

$picture=$response->petfinder->pets->pet[$tempi]->media->photos->photo[2]->param;

if (isset($response->petfinder->pets->pet[$tempi]->media->photos->photo[7])){

$picturetwo=$response->petfinder->pets->pet[$tempi]->media->photos->photo[7]->param;
}

//*******************************************************
//$response->petfinder->pets->pet[$i]->id->param
//$response->petfinder->pets->pet[$i]->name->param  

$prefixtxt=[
"Come rescue",
"Come help",
"Come adopt",
"Come pick up",
"Come meet",
"Come snuggle",
"Come visit",
"Say hi to",
"Meet",
"Rescue",
"Help",
"Adopt",
"Pick up",
"Snuggle",
"Visit"
];


$suffixtxt=[

"now!",
"today!",
"ASAP!",
"pronto!",
"!",
"today!",
"before time runs out!",
"before it's too late!",
"today!",
"!",
"now!",
"soon!"



];


$explanatory=[

"'s such a cutie!",
"'s so sweet!",
" can be your best friend!",
" has so much love to give!",
"'s so affectionate!",
" wants to be your new buddy!",
"'s waiting for you!",
" wants to play!",
"'s ready for snuggles!",
" wants to meet you!",
" wants to love you!",
"'s the sweetest!",
"'s the cuddliest!",
" needs your help!",
" wants to come home with you!",
"'s your new best friend!",
" needs your love!",
" needs a friend!",
"'s the perfect companion!",
" needs your support!",
" needs your generosity!",
"'s the perfect friend!",
"'s the most wonderful pet!",
"'s the most adorable!",
"'s the loveliest!",
" needs a loving home!",
" needs your TLC!",
" wants to be part of your life!",
"'d love a RT!",
" needs as many RTs as possible!",
" needs this seen far and wide!",
" needs a furever home!",
" needs some RTs!",
" wants some hugs!",
" would love a RT or two!"


];



$hashnum=rand(0,count($hashtags)-1);
$explnum=rand(0,count($explanatory)-1);
$suffixnum=rand(0,count($suffixtxt)-1);
$prefixnum=rand(0,count($prefixtxt)-1);
//$hashtagtwo,$petemoji,$emojis
$petemojinum=rand(0,count($petemoji)-1);
$emojisnum=rand(0,count($emojis)-1);
$hashtagtwonum=rand(0,count($hashtagtwo)-1);


if ($response->petfinder->pets->pet[$tempi]->sex->param=="F"){
$gender="She";
}else{
$gender="He";
}


$url='https://www.petfinder.com/petdetail/'.$response->petfinder->pets->pet[$tempi]->id->param;

$name=$response->petfinder->pets->pet[$tempi]->name->param;

$name=strtoupper(preg_replace('/\W.+|\W+/i', '', $name));

// $name regex delete anything after space or punctuation
//$loc=$response->petfinder->pets->pet[$tempi]->contact->city->param;

//$hashtagtwo,$petemoji,$emojis
//$petemojinum,$emojisnum,$hashtagtwonum

$tweet=$petemoji[$petemojinum].' '.$prefixtxt[$prefixnum].' #'.$name.' '.$suffixtxt[$suffixnum].' '.$hashtagtwo[$hashtagtwonum].' '.$gender.$explanatory[$explnum].' '.$emojis[$emojisnum].' '.$hashtags[$hashnum].' '.$url;

//*******************************************************
                    require "inc/twitter_credentials.php";
                    require "vendor/autoload.php";
    
                    use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

$media1 = $connection->upload('media/upload', ['media' => $picture]);
// && rand(0,10)>1
if (isset($picturetwo)){
$media2 = $connection->upload('media/upload', ['media' => $picturetwo]);



$parameters = [
    'status' => $tweet,
    'media_ids' => implode(',', [$media1->media_id_string, $media2->media_id_string])
    //'media_ids' => implode(',', [$media1->media_id_string, $media2->media_id_string])
];

}else{

$parameters = [
    'status' => $tweet,
    'media_ids' => [$media1->media_id_string]
];


}


$result = $connection->post('statuses/update', $parameters);

array_push($d,$response->petfinder->pets->pet[$tempi]->id->param);
$d=json_encode($d);
file_put_contents('data', $d); 
                    
?>
           