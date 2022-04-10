<?php
function topic_link($tid,$string){
    $d=preg_replace('/[?]/','',$string);
    $a=preg_replace('/[@$%^&:<>=_]/','',$d);
    $g=preg_replace('/[#]/','-sharp',$a);
    $r=preg_replace('/[+]/','-plus',$g);
    $w=preg_replace('/[*]/','',$r);
    $w1=preg_replace('/\[/','',$w);
    $w2=preg_replace('/\]/','',$w1);
    $e=preg_replace("/[{}\.!()]/",'',$w2);
    $y=preg_replace("/\\\\/",'',$e);
    $u=str_replace('/','',$y);
    $q=preg_replace("/'/",'',$u);
    $v=preg_replace('/"/','',$q);
    $f=preg_replace('/[ ]/','-',$v);
    $parts=explode('-',$f);
    if($parts[count($parts)-1]==''){
        for($i=0;$i<count($parts)-1;$i++){
            if($parts[$i]!=''){
                $newparts[$i]=$parts[$i];
            }
        }
        $new=implode('-',$newparts);
    }
    else{
        $new=$f;
    }
    $x=$tid.'-'.$new;
    return $x;
}
function q_tiltle($string){
    $d=preg_replace('/[?]/','',$string);
    $a=preg_replace('/[@$%^&:<>=_]/','',$d);
    $g=preg_replace('/[#]/','-sharp',$a);
    $r=preg_replace('/[+]/','-plus',$g);
    $w=preg_replace('/[*]/','',$r);
    $w1=preg_replace('/\[/','',$w);
    $w2=preg_replace('/\]/','',$w1);
    $e=preg_replace("/[{}\.!()]/",'',$w2);
    $y=preg_replace("/\\\\/",'',$e);
    $u=str_replace('/','',$y);
    $q=preg_replace("/'/",'',$u);
    $v=preg_replace('/"/','',$q);
    return $v;
}
function profile_link($id,$string){
    $whole=$id.'-'.$string;
    return $whole;
}
function tag_link($tag){
    $g=preg_replace('/[#]/','-sharp',$tag);
    $r=preg_replace('/[+]/','-plus',$g);
    return $r;
}
function DAT(){
    return date("Y-m-d H:i:s");
}
function only_time(){
    $instance=new DateTime(DAT(),new DateTimeZone("Asia/Tehran"));
    $Date=$instance->format("g:i A");
    return $Date;
}
function geturl(){
    return $_SERVER['REQUEST_URI'];
}
function auto_login($id,$pass,$url){
    $record=PageModel::get_user_info_all_by_user_id($id);
    if($pass==$record['password']){
        $_SESSION['name']=$record['user_name'];
        $_SESSION['mail']=$record['email'];
        $_SESSION['uid']=$record['user_id'];
        $_SESSION['class']=$record['class'];
        header("Location:".$url);
    }
}

function time_calculation($all,$Date){
    $d=0;
    $h=0;
    $min=floor($all/60);
    $sec=$all-($min*60);
    if($min>=60){
        $x=floor($min/60);
        $h=$h+$x;
        $min=$min%60;
        if($h>=24){
            $y=floor($h/24);
            $d=$d+$y;
            $h=$h%24;
        }
    }
    //echo $d.' '.$h.''.$min;exit;
    if($d!=0){
        $one=$d.'d & ';
    }
    else {
        $one='';
    }
    if($h!=0){
        $two=$h.'h & ';
    }
    else {
        $two='';
    }
    if($min!=0){
        $three=$min.'m & ';
    }
    else {
        $three='';
    }
    if($sec!=0){
        $four=$sec.'s ';
    }
    else {
        $four='';
    }
    if($d==1){
        $instance=new DateTime($Date,new DateTimeZone("Asia/Tehran"));
        $Date=$instance->format("g:i A");
        return $Date._yesterday;
    }
    if($d>1){
        $instance=new DateTime($Date,new DateTimeZone("Asia/Tehran"));
        $Date=$instance->format("M j,Y, g:i A");
        return $Date;
    }
    if($one==0&&$two==0&&$three==0&&$four==0){
        return _just_now;
    }
    else {
        return $one.$two.$three.$four._ago;
    }
}
function filter_for_chat($body){
    preg_match_all('/\[color=[a-zA-Z0-9#]+\]/',$body,$colors);
    $cparts=array();
    for($i=0;$i<count($colors[0]);$i++){
        $init=strpos($colors[0][$i],'=');
        $end=strpos($colors[0][$i],']');
        $cparts[$i]=substr($colors[0][$i],$init+1,$end-$init-1);
    }
    //print_r($colors);
    //print_r($cparts);exit;
    for($j=0;$j<count($colors[0]);$j++){
        $body=str_replace('[color='.$cparts[$j].']','<span style="color:'.$cparts[$j].';">',$body);
        $body=str_replace('[/color]','</span>',$body);
    }

    preg_match_all('/\[img\][^\[\]]+\[\/img\]/',$body,$images);
    //print_r($images);
    for($g=0;$g<count($images[0]);$g++){
        preg_match('/(ht|f)tp(|s):\/\/[^\[\]]+/',$images[0][$g],$src);
        //print_r($src);exit;
        $length=strlen($images[0][$g]);
        $num=floor($length/2);
        $str=substr($images[0][$g],$num-5,10);
        //echo $str;
        $n=str_replace('/','',$str);
        $m=str_replace('.','',$n);
        $e=str_replace('-','',$m);
        $f=str_replace('_','',$e);
        $k=str_replace(']','',$f);
        $b=str_replace('[','',$k);
        //echo $b;
        $ran=rand(1,100);
        $key=$b.$ran;
        //echo $key;exit;
        $body=str_replace($images[0][$g],'<div><span class="chat-btn2" onclick="spoiler('."'$key'".')">spoil</span><div class="none" id="spoiler-div-'.$key.'"><img src="'.$src[0].'"></div></div>',$body);
        //preg_replace('/\[img\][^\[\]]+\[\/img\]/','<div><span class="chat-btn2" onclick="spoiler('."'$key'".')">spoil</span><div class="none" id="spoiler-div-'.$key.'"><img src="'.$src[0].'"></div></div>',$body,1);
    }


    preg_match_all('/\[vid\][^\[\]]+\[\/vid\]/',$body,$video);
    //print_r($images);
    for($h=0;$h<count($video[0]);$h++){
        preg_match('/(ht|f)tp(|s):\/\/[^\[\]]+/',$video[0][$h],$src);
        //print_r($src);exit;
        $length=strlen($video[0][$h]);
        $num=floor($length/2);
        $str=substr($video[0][$h],$num-5,10);
        //echo $str;
        $n=str_replace('/','',$str);
        $m=str_replace('.','',$n);
        $e=str_replace('-','',$m);
        $f=str_replace('_','',$e);
        $k=str_replace(']','',$f);
        $b=str_replace('[','',$k);
        //echo $b;
        $ran=rand(1,100);
        $key=$b.$ran;
        //echo $key;exit;
        $body=str_replace($video[0][$h],'<div><span class="chat-btn2" onclick="spoiler('."'$key'".')">spoil</span><div class="none" id="spoiler-div-'.$key.'"><iframe controls height="240" width="320" src="'.$src[0].'"></iframe></div></div>',$body);
        //preg_replace('/\[img\][^\[\]]+\[\/img\]/','<div><span class="chat-btn2" onclick="spoiler('."'$key'".')">spoil</span><div class="none" id="spoiler-div-'.$key.'"><img src="'.$src[0].'"></div></div>',$body,1);
    }




    preg_match_all('/@\[[A-Za-z0-9]+(?:[_-][A-Za-z0-9]*)*\]/',$body,$mentions);

    $names=array();
    for($r=0;$r<count($mentions[0]);$r++){
        $end=strpos($mentions[0][$r],']');
        $len=$end-1;
        $names[$r]=substr($mentions[0][$r],2,$len-1);
    }
    for($p=0;$p<count($names);$p++){
        $recs=PageModel::get_info_for_chat($names[$p]);
        $body=str_replace('['.$names[$p].']','<a class="'.$recs['class'].'" href=/'._main_lang.'/page/profile/'.profile_link($recs['user_id'],$names[$p]).'>'.$names[$p].'</a>',$body);
    }
    $body=preg_replace('/\[b\]/','<span style="font-weight: bold">',$body);
    $body=preg_replace('/\[\/b\]/','</span>',$body);
    $body=preg_replace('/\[B\]/','<span style="font-weight: bolder">',$body);
    $body=preg_replace('/\[\/B\]/','</span>',$body);
    $body=preg_replace('/\[s\]/','<span style="text-decoration: line-through">',$body);
    $body=preg_replace('/\[\/s\]/','</span>',$body);
    $body=preg_replace('/\[u\]/','<span style="text-decoration: underline">',$body);
    $body=preg_replace('/\[\/u\]/','</span>',$body);
    $body=preg_replace('/\[i\]/','<span style="font-style: italic">',$body);
    $body=preg_replace('/\[\/i\]/','</span>',$body);
    $body=preg_replace('/\[blink\]/','<span class="blink">',$body);
    $body=preg_replace('/\[\/blink\]/','</span>',$body);
    $body=preg_replace('/\[code\]/','<span style="background-color: #ddd;color: #444;padding: 2px 4px;">',$body);
    $body=preg_replace('/\[\/code\]/','</span>',$body);
    preg_match_all('/(ht|f)tp(|s):\/\/[a-zA-Z0-9\.\/]+/',$body,$links);
    $body=preg_replace('/\b(((?:GM(?!.*\1)))(?!.*\1))\b/','Good morning',$body);
    $body=preg_replace('/\b(((?:GN(?!.*\1)))(?!.*\1))\b/','Good night',$body);
    //print_r($links);exit;
    for($l=0;$l<count($links[0]);$l++){
        $body=str_replace('[url]','<a class="chat-links" href='.$links[0][$l].'>',$body);
        $body=str_replace('[/url]','</a>',$body);
    }
    //print_r($bolds);
    //exit;
    return $body;
}
?>