function savedPOST() {
    //  Path:   views/components/saveFinish.php
    document.getElementById('load-data-notification').classList.add('hidden');
    document.getElementById('save-finish-notification').classList.remove('hidden');
    setTimeout(
        function() {
            document.getElementById('save-finish-notification').classList.add('hidden');
        }, 200);
}

function loadData() {
    document.getElementById('load-data-notification').classList.remove('hidden');
   
}

function uuidv4() {
    return Date.now().toString(16).toUpperCase();

  }



/**
 * ========================================================================
 * ========================================================================
 * 
 *!   $$$$$$$\                      $$\         $$\     $$\                     $$\       
 *!   $$  __$$\                     $$ |        $$ |    \__|                    $$ |      
 *!   $$ |  $$ | $$$$$$\   $$$$$$$\ $$ |  $$\ $$$$$$\   $$\  $$$$$$$\  $$$$$$$\ $$$$$$$\  
 *!   $$$$$$$  | \____$$\ $$  _____|$$ | $$  |\_$$  _|  $$ |$$  _____|$$  _____|$$  __$$\ 
 *!   $$  ____/  $$$$$$$ |$$ /      $$$$$$  /   $$ |    $$ |\$$$$$$\  $$ /      $$ |  $$ |
 *!   $$ |      $$  __$$ |$$ |      $$  _$$<    $$ |$$\ $$ | \____$$\ $$ |      $$ |  $$ |
 *!   $$ |      \$$$$$$$ |\$$$$$$$\ $$ | \$$\   \$$$$  |$$ |$$$$$$$  |\$$$$$$$\ $$ |  $$ |
 *!   \__|       \_______| \_______|\__|  \__|   \____/ \__|\_______/  \_______|\__|  \__|
 *
 * ========================================================================
 * ========================================================================
 */







 