<?php
    //カレンダー機能のPHP部分
     
    //タイムゾーンを設定 
    date_default_timezone_set('Asia/Tokyo'); 
     
    // 前月・次月リンクが押された場合は、GETパラメーターから年月を取得 
    if (isset($_GET['ym'])) { 
        $ym = $_GET['ym']; 
    } else { 
    // 今月の年月を表示 
        $ym = date('Y-m'); 
    } 
     
    // タイムスタンプを作成し、フォーマットをチェックする 
    $timestamp = strtotime($ym . '-01'); 
    if ($timestamp === false) { 
        $ym = date('Y-m'); 
        $timestamp = strtotime($ym . '-01'); 
    } 
     
    // 今日の日付 フォーマット　例）2021-06-3 
    $today = date('Y-m-d');
     
    // カレンダーのタイトルを作成　例）2021年6月 
    $html_title = date('Y年n月', $timestamp); 
     
    // 前月・次月の年月を取得 
    // 方法１：mktimeを使う mktime(hour,minute,second,month,day,year) 
    $prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp))); 
    $next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp))); 
     
    // 該当月の日数を取得 
    $day_count = date('t', $timestamp); 
     
    // １日が何曜日か　0:日 1:月 2:火 ... 6:土 
    // 方法１：mktimeを使う 
    $youbi = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp))); 
     
    // カレンダー作成の準備 
    $weeks = []; 
    $week = ''; 
     
    // 第１週目：空のセルを追加 
    // 例）１日が火曜日だった場合、日・月曜日の２つ分の空セルを追加する 
    $week .= str_repeat('<td id="c-td"></td>', $youbi); 
     
    //タスク数え上げ関数の定義
    function md_date($date,$m_results){
        $md_results=array();
        foreach($m_results as $row){
            if($date==$row['date']){
                array_push($md_results,$row['id']);
            }
        }
        return $md_results;
    }
    function td_date($date,$t_results){
        $td_results=array();
        foreach($t_results as $row){
            if($date==$row['due_date']){
                array_push($td_results,$row['id']);
            }
        }
        return $td_results;
    }
     
     
    for ( $day = 1; $day <= $day_count; $day++, $youbi++) { 
        // $dateをyyyy-mm-dd形式の文字列に
        if($day < 10){
            $date = $ym .'-'.'0'.$day;
        }else{
            $date = $ym .'-'. $day;
        }
         
         //タスク数（変換）
        if(count(md_date($date,$m_results)) > 0){
            $n_num="<a href=./each_date.php?date=".$date.">".count(md_date($date,$m_results))."</a>";
        }else{
            $n_num="×";
        }
        if(count(td_date($date,$t_results)) > 0){
            $t_num="<a href=./each_date.php?date=".$date.">".count(td_date($date,$t_results))."</a>";
        }else{
            $t_num="×";
        }
         
        if ($today == $date) { 
            // 今日の日付の場合は、class="today"をつける 
            $week .= '<td class="today">' . $day; 
        } else { 
            $week .= '<td id="c-td">' . $day; 
        }
         
        $week .= '<p>'.$n_num.$t_num.'</p>'.'</td>'; 
         
        // 週終わり、または、月終わりの場合 
        if ($youbi % 7 == 6 || $day == $day_count) { 
             
            if ($day == $day_count) { 
                // 月の最終日の場合、空セルを追加 
                $week .= str_repeat('<td id="c-td"></td>', 6 - $youbi % 7); 
            } 
            // weeks配列にtrと$weekを追加する 
            $weeks[] = '<tr>' . $week . '</tr>'; 
             
            // weekをリセット 
            $week = ''; 
        } 
    }
?>