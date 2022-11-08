<template>
    <div id="header" class="active">

        <div class="header-wrap row-group">
            <div class="top-menu col-group">
                <ul class="col-group">
                    <li>
                        <a href="/shopping">
                            흙침대 mall
                        </a>
                    </li>
                    <li>
                        <a href="">
                            소프라믹
                        </a>
                    </li>
                    <li>
                        <a href="">
                            메종바로바우
                        </a>
                    </li>
                </ul>
                <form action="" @submit.prevent="search">
                    <div class="header-search">
                        <input type="text" placeholder="검색어를 입력하세요." v-model="form.word">
                        <button type="submit"></button>
                    </div>
                </form>
            </div>

            <h1 class="logo">
                <a href="/"></a>
            </h1>
            <nav class="gnb-wrap col-group">
                <ul class="gnb left col-group">
                    <li v-for="category in categories.data" :key="category.id">
                        <a :href="`/brand/products?category_id=${category.id}`">
                            {{ category.title }}
                        </a>
                    </li>
                </ul>
                <ul class="gnb right col-group">
                    <li>
                        <a href="/brand/story1">
                            흙침대 이야기
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="/brand/story1">
                                    흙표흙침대의 가치
                                </a>
                            </li>
                            <li>
                                <a href="/brand/story2">
                                    흙표흙침대의 효과
                                </a>
                            </li>
                            <li>
                                <a href="/brand/story3">
                                    흙표흙침대의 철학
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="/brand/reviews">
                            흙소식
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="/brand/reviews">
                                    고객후기
                                </a>
                            </li>
                            <li>
                                <a href="/brand/brandEvents">
                                    이벤트
                                </a>
                            </li>
                            <li>
                                <a href="/brand/brandEvents?type=SNS">
                                    SNS
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="/brand/stores">
                            매장안내
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="/brand/stores">
                                    매장검색
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    소프라믹
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    메종바로바우
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul class="icon-menu col-group">
                            <li class="mypage-btn">
                                <a href="/shopping/carts"></a>
                            </li>
                            <li class="sitemap-btn">
                                <a href="#"></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <button class="search-btn mb" type="button">
                <i class="xi-search"></i>
            </button>
            <button class="sitemap-btn mb" type="button">
                <i class="xi-bars"></i>
            </button>
        </div>

        <div class="site-map">
    <span class="close">
        <i class="xi-close"></i>
    </span>
            <div class="col-group">
                <div class="mid mb">
                    <div class="col-group">
                        <!-- 로그아웃 상태일 때-->
                        <a href="/shopping/login" class="login-txt" v-if="!user">
                            로그인을 해주세요
                            <i class="xi-angle-right"></i>
                        </a>

                        <p class="login-txt" v-else>
                            반갑습니다! {{ user.name }}님
                        </p>
                        <!-- //로그아웃 상태일 때-->

                        <!-- 로그인 상태일 때-->
                        <!-- <p class="login-txt">
                            반갑습니다! 김흙표님
                        </p> -->
                        <!-- //로그인 상태일 때-->

                        <a href="/shopping" class="link">
                            흙침대 mall
                        </a>
                    </div>
                </div>
                <div class="left">
                    <p class="mb">
                        제품 카테고리
                    </p>
                    <ul class="left-menu col-group">
                        <li class="animate__animated animate__faster"  v-for="category in categories.data" :key="category.id">
                            <a :href="`/brand/products?category_id=${category.id}`">
                                {{ category.title }}
                                <span class="mb">
                            <i class="xi-angle-right"></i>
                        </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="right col-group">
                    <ul class="mid-menu">
                        <li class="animate__animated">
                            <p>
                                흙침대 이야기
                                <span class="mb">
                            <i class="xi-plus"></i>
                        </span>
                            </p>
                            <ul class="sub-menu">
                                <li>
                                    <a href="/brand/story1">
                                        흙표흙침대의 가치
                                    </a>
                                </li>
                                <li>
                                    <a href="/brand/story2">
                                        흙표흙침대의 효과
                                    </a>
                                </li>
                                <li>
                                    <a href="/brand/story3">
                                        흙표흙침대의 철학
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="animate__animated">
                            <p>
                                흙소식
                                <span class="mb">
                            <i class="xi-plus"></i>
                        </span>
                            </p>
                            <ul class="sub-menu">
                                <li>
                                    <a href="/brand/reviews">
                                        고객후기
                                    </a>
                                </li>
                                <li>
                                    <a href="/brand/brandEvents">
                                        이벤트
                                    </a>
                                </li>
                                <li>
                                    <a href="/brand/brandEvents?type=SNS">
                                        SNS
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="animate__animated">
                            <p>
                                매장안내
                                <span class="mb">
                            <i class="xi-plus"></i>
                        </span>
                            </p>
                            <ul class="sub-menu">
                                <li>
                                    <a href="/brand/stores">
                                        매장검색
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        소프라믹
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        메종바로바우
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="animate__animated">
                            <p>
                                회사소개
                                <span class="mb">
                            <i class="xi-plus"></i>
                        </span>
                            </p>
                            <ul class="sub-menu">
                                <li>
                                    <a href="/brand/history">
                                        흙의 역사
                                    </a>
                                </li>
                                <li>
                                    <a href="/brand/certification">
                                        수상 및 인증
                                    </a>
                                </li>
                                <li>
                                    <a href="/brand/videos">
                                        라이브러리
                                    </a>
                                </li>
                                <li>
                                    <a href="/brand/wayToCome">
                                        오시는 길
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="animate__animated">
                            <p>
                                고객지원
                                <span class="mb">
                            <i class="xi-plus"></i>
                        </span>
                            </p>
                            <ul class="sub-menu">
                                <li>
                                    <a href="/brand/faqs">
                                        자주 묻는 질문
                                    </a>
                                </li>
                                <li>
                                    <a href="/brand/homecare">
                                        홈케어서비스
                                    </a>
                                </li>
                                <li>
                                    <a href="/brand/qnas/create">
                                        AS신청 및 상담
                                    </a>
                                </li>
                                <li>
                                    <a href="/brand/catalogs">
                                        제품 매뉴얼
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="animate__animated">
                            <p>
                                기타안내
                                <span class="mb">
                            <i class="xi-plus"></i>
                        </span>
                            </p>
                            <ul class="sub-menu">
                                <li>
                                    <a href="/brand/policy1">
                                        이용약관
                                    </a>
                                </li>
                                <li>
                                    <a href="/brand/policy2">
                                        개인정보보호정책
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="right-menu">
                        <li class="animate__animated animate__faster">
                            <a href="/brand">
                                <p>
                                    흙표흙침대몰<br>
                                    바로가기
                                </p>
                            </a>
                        </li>
                        <li class="animate__animated animate__faster">
                            <a href="">
                                <p>
                                    메종바로바우<br>
                                    바로가기
                                </p>
                            </a>
                        </li>
                        <li class="animate__animated animate__faster">
                            <a href="">
                                <p>
                                    소프라믹<br>
                                    바로가기
                                </p>
                            </a>
                        </li>
                        <li class="animate__animated animate__faster">
                            <a href="">
                                <p>
                                    두도<br>
                                    바로가기
                                </p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
import {Link} from '@inertiajs/inertia-vue';
export default {
    components: {Link},
    data(){
        return {
            pathname: location.pathname,
            categories: this.$page.props.categories,
            user: this.$page.props.user ? this.$page.props.user.data : "",
            form: this.$inertia.form({
                word: ""
            }),
        }
    },
    methods: {
        search(){
            this.form.get("/brand/searches");
        },

        init(){
            if($(".mainpage").length === 0)
                $("body").addClass("subpage");
            else
                $("body").addClass("mainpage");

            //페이지 스크롤시 헤더 색상 변경
            $(window).scroll(function(){
                var scrollTop = $(window).scrollTop();
                if ( scrollTop > 0 ) {
                    $(".mainpage #header").addClass("active");
                } else {
                    $(".mainpage #header").removeClass("active");
                }
            });

            //서브페이지 헤더색상 고정
            $(document).ready(function(){
                $(".subpage #header").addClass("active");
            });

            //pc페이지 헤더 호버효과
            $('#header .gnb').hover(function(){
                $('#header').addClass('toggle');
                $('#header .gnb .sub-menu').stop().slideDown();
                if ( $('#header').hasClass('toggle') ) {
                    $('#header').mouseleave(function(){
                        $('#header').removeClass('toggle');
                        $('#header .gnb .sub-menu').stop().slideUp();
                    });
                }
            });




            if( ($(document).width()) > 768 ) {

                //사이트맵
                $('.sitemap-btn').click(function(){
                    $('.site-map').addClass('show');
                    $('.animate__animated').addClass('animate__fadeInUp');
                    $('body').css('overflow', 'hidden')
                });
                $('.site-map .close').click(function(){
                    $('.site-map').removeClass('show');
                    $('.animate__animated').removeClass('animate__fadeInUp');
                    $('body').css('overflow', 'unset')
                });


            } else {

                //사이트맵
                $('.sitemap-btn').click(function(){
                    $('.site-map').addClass('show');
                    $('body').css('overflow', 'hidden')
                });
                $('.site-map .close').click(function(){
                    $('.site-map').removeClass('show');
                    $('body').css('overflow', 'unset')
                });

                //사이트맵 메뉴 슬라이드
                $('.site-map .mid-menu li> p').click(function(){
                    $(this).next('.sub-menu').slideToggle();
                    $(this).toggleClass('active');
                    if ( $(this).hasClass('active') ) {
                        $(this).children('span').children('i').removeClass('xi-plus')
                        $(this).children('span').children('i').addClass('xi-minus')
                    } else {
                        $(this).children('span').children('i').addClass('xi-plus')
                        $(this).children('span').children('i').removeClass('xi-minus')
                    }
                });

            }

            //모바일 검색창
            $('#header .search-btn').click(function(){
                $('.header-search').toggleClass('active');
            });

            //통신판매업신고번호
            var url = "http://www.ftc.go.kr/bizCommPop.do?wrkr_no=6038121138"
            $('.footer-wrap .link').click(function () {
                window.open(url, "bizCommPop", "width=750, height=700;");
                return false;
            });

            //사이드 버튼
            $('.side-btn button img').click(function(){
                $(this).parent('button').toggleClass('active')
            });
        }
    },
    computed: {

    },

    mounted() {
        this.init();

        this.$inertia.on("start", () => {
            this.pathname = location.pathname;
        });

    }
}
</script>
