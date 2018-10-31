<script src="materialize/js/jquery.min.js"></script>
<script src="materialize/js/materialize.min.js"></script>
<script type="text/javascript">

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#userimg').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).ready(function(){
        $('.collapsible').collapsible();
        $('select').formSelect();

        // hide #back-top first
        $("#back-top").hide();
        
        // fade in #back-top
        $(function () {
            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $('#back-top').fadeIn();
                } else {
                    $('#back-top').fadeOut();
                }
            });

            // scroll body to 0px on click
            $('#back-top a').click(function () {
                $('body,html').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });
        });
        
        $("#image").change(function() {
            readURL(this);
        });

        $("#diary-content").removeClass('scale-out').addClass('scale-in');
        
        $("#public-content").removeClass('scale-out').addClass('scale-in');

        $("#setting-content").removeClass('scale-out').addClass('scale-in');

        $('.dropdown-trigger').dropdown();
        
        $(".fadein").fadeTo("slow", 1);

        $(".add-tool, .tobedel, .delete, .viewstory, .viewdiary, .editdiary, .forget, .editstory").tooltip();

        $('.datepicker').datepicker();

        $('.modal').modal();

        $('.editdiary').click(function(){
            var label = $(this).data('label');
            var id = $(this).data('id');
            $("#ulabel").val(label);
            $("#uid").val(id);
        });

        $('.viewstory').click(function(){
            var storytitle = $(this).data('title');
            var storycontent = $(this).data('content');
            var storydate = $(this).data("date");
            var like = $(this).data("like");
            var id = $(this).data('id');
            $("#vtitle").html(storytitle);
            $("#vcontent").html(storycontent);
            $("#vdate").html("Date: "+storydate);
            $("#vlikes").html("Total Like: "+like);
        });

        $('.editstory').click(function(){
            var storytitle = $(this).data('title');
            var storycontent = $(this).data('content');
            var storydate = $(this).data('date');
            var id = $(this).data('id');
            var priv = $(this).data('priv');
            $("#ustorytitle").val(storytitle);
            $("#ustorydetails").val(storycontent);
            $("#storyid").val(id);
            $("#date").val(storydate);
        });
        
        $(".forget").click(function(){
            if(confirm("Are you sure you want to permanently forget this diary? This cannot be changed."))
            {
                var id = $(this).data('diaryid');
                window.location.assign("../controller/forget_diary.php?diaryid="+id);
            }
        });

        $(".delete").click(function(){
            if(confirm("Are you sure you want to permanently delete this diary? This cannot be changed."))
            {
                var id = $(this).data('diaryid');
                window.location.assign("../controller/delete_diary.php?diaryid="+id);
            }
        });

        $(".sharestory").click(function(){
            if(confirm("Are you sure you want to share this story to everyone?"))
            {
                var id = $(this).data('id');
                var diaryid = $(this).data('diaryid');
                window.location.assign("../controller/share_story.php?diaryid="+diaryid+"&storyid="+id);
            }
        });

        $('.fixed-action-btn').removeClass('scale-out').addClass('scale-in');
        $('#liststory').hide();
        $('.pageview').click(function(){
            $('#listdiary').addClass('scale-out');
            $('#listdiary').hide();
            $('#liststory').show();
            $('#liststory').removeClass('scale-out').addClass('scale-in');
            
        });

        $(".close").click(function(){
            $(this).parent().hide("slow");
        });

        $(".notifyDrop").click(function() {
			$(this).next(".prompt").slideToggle("medium");   
            $("#clearB").html("");
            
		});

        $("#diarylabel").characterCounter();
        $("#storytitle").characterCounter();
        $("#storydetails").characterCounter();
        $("#ustorytitle").characterCounter();
        $("#ustorydetails").characterCounter();
        $("#ulabel").characterCounter();

        $("#profile-setting").hide();
        $("#profile-image").hide();
        $("#change-pass").hide();

        $("#pbtn").click(function(){
            $("#profile-image").hide();
            $("#profile-image").removeClass('scale-in').addClass('scale-out');
            $("#change-pass").hide();
            $("#change-pass").removeClass('scale-in').addClass('scale-out');
            $("#profile-setting").show();
            $("#profile-setting").removeClass('scale-out').addClass('scale-in');
        });
        $("#ibtn").click(function(){
            $("#profile-setting").hide();
            $("#profile-setting").removeClass('scale-in').addClass('scale-out');
            $("#change-pass").hide();
            $("#change-pass").removeClass('scale-in').addClass('scale-out');
            $("#profile-image").show();
            $("#profile-image").removeClass('scale-out').addClass('scale-in');
        });
        $("#cbtn").click(function(){
            $("#profile-setting").hide();
            $("#profile-setting").removeClass('scale-in').addClass('scale-out');
            $("#profile-image").hide();
            $("#profile-image").removeClass('scale-in').addClass('scale-out');
            $("#change-pass").show();
            $("#change-pass").removeClass('scale-out').addClass('scale-in');
        });
    });
</script>