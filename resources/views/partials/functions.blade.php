<script>
    var wasSubmitted = false;    
    function checkBeforeSubmit(){
        if(!wasSubmitted) {
            wasSubmitted = true;
            return wasSubmitted;
        }
        return false;
    }
</script>
<script>
    $(document).ready(function(){
        function numberFormating(e, element){
            var selection = window.getSelection().toString();
            if ( selection !== '' ) {
                return;
            }
            
            // When the arrow keys are pressed, abort.
            if ( e != null ){
                if ( $.inArray( e.keyCode, [38,40,37,39] ) !== -1 ) {
                    return;
                }
            }
            
            // console.log(e.keyCode);
            var $this = element;
            
            // Get the value.
            var input = $this.val();
            
            var input = input.replace(/[\D\s\._\-]+/g, "");
            input = input ? parseInt( input, 10 ) : 0;

            $this.val( function() {
                return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
            } );
        }
        $('input[name="jumlah[]"], input[name="harga[]"]').keyup(function(e){
            numberFormating(event, $(this));
        });
        
        $('input[name="jumlah[]"], input[name="harga[]"]').change(function(e){
            console.log($(this));
            numberFormating(event, $(this));
        });
        
        $.each($('input[name="jumlah[]"], input[name="harga[]"]'), function( index, value ) {
            // console.log($(value).val());
            numberFormating(null, $(value));
        });

        $('#button-see-password').on('click', function(e){
            if ( $('#pass-eye-icon').hasClass('fa-eye-slash') ){
                $('input[name="password"]').attr('type', 'text');
                $('input[name="password2"]').attr('type', 'text');
                $('#pass-eye-icon').removeClass('fa-eye-slash');
                $('#pass-eye-icon').addClass('fa-eye');
            }else if ( $('#pass-eye-icon').hasClass('fa-eye') ){
                $('input[name="password"]').attr('type', 'password');
                $('input[name="password2"]').attr('type', 'password');
                $('#pass-eye-icon').removeClass('fa-eye');
                $('#pass-eye-icon').addClass('fa-eye-slash');
            }
        })
        
        $('#button-see-password2').on('click', function(e){
            if ( $('#pass-eye-icon2').hasClass('fa-eye-slash') ){
                $('input[name="password"]').attr('type', 'text');
                $('input[name="password2"]').attr('type', 'text');
                $('#pass-eye-icon2').removeClass('fa-eye-slash');
                $('#pass-eye-icon2').addClass('fa-eye');
            }else if ( $('#pass-eye-icon2').hasClass('fa-eye') ){
                $('input[name="password"]').attr('type', 'password');
                $('input[name="password2"]').attr('type', 'password');
                $('#pass-eye-icon2').removeClass('fa-eye');
                $('#pass-eye-icon2').addClass('fa-eye-slash');
            }
        })
    })
</script>