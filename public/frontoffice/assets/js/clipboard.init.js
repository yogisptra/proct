new ClipboardJS('.ctc');

$('.ctc').click(function() {
    $('main').append(`
        <div class="copy-toast position-fixed w-full transition-all invisible opacity-0">
            <div style="max-width: 480px" class="mx-auto bg-success text-white py-2 shadow">
                <div class="container text-center">
                    <span>Berhasil Disalin</span>
                </div>
            </div>
        </div>
    `)

    setTimeout(function(){
        $('.copy-toast').removeClass(['invisible', 'opacity-0']);
    },1);
    
    setTimeout(function(){
        $('.copy-toast').addClass(['invisible', 'opacity-0']);
    },1000);

    setTimeout(function(){
        $('.copy-toast').remove()
    },2000);
})