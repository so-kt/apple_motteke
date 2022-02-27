
//javascriptファイル

function checkDel(){
    if(window.confirm('削除しますか？')){
        return true;
    }else{
        return false;  
    }
}
    
function checkDone(){
    if(window.confirm('持ち物はすべて持ちましたか？')){
        return true;
    }else{
        return false;  
    }
}