<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Gituser;
use App\User;

class MyControler extends Controller
{
    //

    public function host($url){

        $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';


        $ch = curl_init($url);
        // устанавлваем даные для отправки
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_HEADER, false);
        // отправляем запрос
        $response = curl_exec($ch);
        // закрываем соединение
        curl_close($ch);

        return $response;

    }

    public function get_users(Request $request, $order){

        $arr=$request->header();
        $login=$arr["php-auth-user"][0];
        $password=$arr["php-auth-pw"][0];
        $auth_users=User::where('email',$login)->first();
        if (Hash::check($password, $auth_users->password)){


            $array=array();

            if ($order=='' || ($order!='asc' && $order!='desc')){
                $order='asc';
            }

            $users=Gituser::where('name','!=','')->orderBy('count_rep', $order)->get();
            foreach ($users as $user) {
                if ($user->count_rep==NULL)
                    $count=0;
                else
                    $count=$user->count_rep;

                $array[]=array('name'=>$user->name,'resp'=>$count);
            }

            echo json_encode($array);
        } else{
            echo '{"error":"Ошибка авторизации"}';
        }





    }

    public function request_users($name){

        $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';

        $url="http://test.ra-nix.com/get_users/desc";
        $url="http://test.ra-nix.com/git_user/".$name;

        // dd($url);


        $ch = curl_init($url);
        // устанавлваем даные для отправки
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_USERPWD, "st_nikon@mail.ru:loci8awl1");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_HEADER, false);
        // отправляем запрос
        $response = curl_exec($ch);
        // закрываем соединение
        curl_close($ch);

        echo $response;



    }



    public function show(Request $request, $name){
        $arr=$request->header();
        $login=$arr["php-auth-user"][0];
        $password=$arr["php-auth-pw"][0];
        $auth_users=User::where('email',$login)->first();
        if (Hash::check($password, $auth_users->password)){

            $Git_arr=array();

            // $arr_name=Gituser::where('name','!=','')->pluck('name')->toArray();
            // dd($arr_name);


            $user=json_decode($this->host('https:/api.github.com/users/'.$name));

            // dump($user);

            $array=json_decode($this->host("https://api.github.com/users/".$user->login."/following"));

            $gituser=Gituser::where('name',$user->login)->get();

            // dump($array);

            $Git_arr[]=$user->login;

            // if (in_array($user->login, $arr_name)){
            if (count($gituser)>0){
                $gituser[0]->count_rep=count(json_decode($this->host($user->repos_url)));
                $gituser[0]->save();
                $id_section=$gituser[0]->id;
            } else{
                $guser=new Gituser;
                $guser->name=$user->login;
                $follow=explode('{', $user->following_url);
                $guser->followers_url=$follow[0];
                $guser->repos_url=$user->repos_url;
                $guser->id_section=0;
                $guser->count_rep=count(json_decode($this->host($user->repos_url)));
                $guser->save();
                $id_section= Gituser::max('id');
            }


            // dump($array);

            foreach ($array as $key => $value) {

                if (!in_array($value->login, $Git_arr) ){
                    $Git_arr[]=$value->login;
                }

                $gituser=Gituser::where('name',$value->login)->get();
                $count=count(json_decode($this->host($value->repos_url)));
                // if (in_array($value->login, $arr_name)){
                if (count($gituser)){
                    $gituser[0]->count_rep=$count;
                    $gituser[0]->id_section=$id_section;
                    $gituser[0]->save();
                    $id_section2=$gituser[0]->id_section;
                } else {
                    $guser=new Gituser;
                    $follow=explode('{', $value->following_url);
                    $guser->followers_url=$follow[0];
                    $guser->name=$value->login;

                    $guser->id_section=$id_section;
                    $guser->repos_url=$value->repos_url;
                    $guser->count_rep=$count;
                    $guser->save();
                    $id_section2= Gituser::max('id');
                }

                $array2=json_decode($this->host("https://api.github.com/users/".$value->login."/following"));

                // dd($array2);

                foreach ($array2 as $key2 => $value2) {

                    if (isset($value2->login) && $value->login!=''){

                        if (!in_array($value2->login, $Git_arr) ){
                            $Git_arr[]=$value2->login;
                        }

                        $gituser=Gituser::where('name',$value2->login)->get();
                        $count2=count(json_decode($this->host($value2->repos_url)));
                        // if (in_array($value2->login, $arr_name)){
                        if (count($gituser)){
                            $gituser[0]->count_rep=$count2;
                            $gituser[0]->id_section=$id_section2;
                            $gituser[0]->save();
                        } else {
                            $guser=new Gituser;
                            $guser->name=$value2->login;
                            $follow=explode('{', $value2->following_url);
                            $guser->followers_url=$follow[0];
                            $guser->repos_url=$value2->repos_url;
                            $guser->id_section=$id_section2;
                            $guser->count_rep=$count2;
                            $guser->save();
                        }
                    }

                }

            }



            echo json_encode($Git_arr);

        }else{
            echo '{"error":"Ошибка авторизации"}';
        }




    }
}