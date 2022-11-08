$(document).ready(function(){
    Kakao.init('1ef231cd0a39ca2c5c751d0ab9d7c5ee');

    ///////
    // 내댓글,북마크,최근활동 탭 정리
    //////
    /*$("#tab_bookmark").click(function () {
 
       $("#tab_curation").removeClass('on');
       $("#tab_livere").removeClass('on');
       $("#tab_recently").removeClass('on');
       $("#tab_bookmark").addClass('on');

       $('#div_bookmark').removeClass('hide');
       $('#div_livere').addClass('hide');
       $('#div_recently').addClass('hide');
       $("#div_curation").addClass('hide');
    });
    $("#tab_livere").click(function () {
 
       $("#tab_curation").removeClass('on');
       $("#tab_bookmark").removeClass('on');
       $("#tab_recently").removeClass('on');
       $("#tab_livere").addClass('on');

       $("#div_curation").addClass('hide');
       $('#div_bookmark').addClass('hide');
       $('#div_recently').addClass('hide');
       $('#div_livere').removeClass('hide');
 
    });
    $("#tab_recently").click(function () {
 
       $("#tab_curation").removeClass('on');
       $("#tab_bookmark").removeClass('on');
       $("#tab_livere").removeClass('on');
       $("#tab_recently").addClass('on');
 
       $("#div_curation").addClass('hide');
       $('#div_bookmark').addClass('hide');
       $('#div_livere').addClass('hide');
       $('#div_recently').removeClass('hide');
    });

    $("#tab_curation").click(function () {
 
        $("#tab_bookmark").removeClass('on');
        $("#tab_livere").removeClass('on');
        $("#tab_recently").removeClass('on');
        $("#tab_curation").addClass('on');

        $('#div_curation').removeClass('hide');
        $('#div_livere').addClass('hide');
        $('#div_recently').addClass('hide');
        $('#div_bookmark').addClass('hide');
     });
 
     
     //마이페이지 퀴즈 내역
     $('.mypagetab li').click(function(){
        $(".mypagetab li").removeClass("active");
        $(this).addClass("active");
        var tab_id = $(this).attr('data-tab');
        $('.tab_content').removeClass('active');

        $(".tab_content#"+tab_id).addClass('active');
    });

     $('.quizlist> li').click(function(){
        $('.quizlist> li').removeClass('active');
        $(this).toggleClass('active');
        $('.quiz_a').stop().slideUp();
        $(this).children('.quiz_a').stop().slideToggle();
    });


    //마이페이지 뉴스 소비량
    $('.mypagesubtab li').click(function(){
      $(".mypagesubtab li").removeClass("active");
      $(this).addClass("active");
      var tab_id = $(this).attr('data-tab');
      $('.tab_content').removeClass('active');

      $(".tab_content#"+tab_id).addClass('active');
      
   });*/

   /*$({ val : 0 }).animate({ val : 6512 }, {
      duration: 1000,
      step: function() {
          var num = numberWithCommas(Math.floor(this.val));
          $(".count_num").text(num);
      },
      complete: function() {
          var num = numberWithCommas(Math.floor(this.val));
          $(".count_num").text(num);
      }
  });

  $({ val : 0 }).animate({ val : 2200000 }, {
      duration: 1000,
      step: function() {
          var num = numberWithCommas(Math.floor(this.val));
          $(".count_num2").text(num);
      },
      complete: function() {
          var num = numberWithCommas(Math.floor(this.val));
          $(".count_num2").text(num);
      }
  });

  $({ val : 0 }).animate({ val : 19 }, {
      duration: 1000,
      step: function() {
          var num = numberWithCommas(Math.floor(this.val));
          $(".count_num3").text(num);
      },
      complete: function() {
          var num = numberWithCommas(Math.floor(this.val));
          $(".count_num3").text(num);
      }
  });*/

  function numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }


 });
