<template>
    <div id="header" class="active">

        <div class="header-wrap row-group">
            <div class="top-menu col-group">
                <ul class="col-group">
                    <li>
                        <a href="/brand" target="_blank">
                            흙표흙침대
                        </a>
                    </li>
                    <li>
                        <a href="" target="_blank">
                            소프라믹
                        </a>
                    </li>
                    <li>
                        <a href="" target="_blank">
                            메종바로바우
                        </a>
                    </li>
                </ul>
            </div>

            <nav class="gnb-wrap col-group">
                <h1 class="logo">
                    <a href="/shopping"></a>
                    <p>
                        mall
                    </p>
                </h1>
                <ul class="gnb col-group">
                    <li v-for="category in categories.data" :key="category.id">
                        <a :href="`/shopping/products?category_id=${category.id}`">
                            {{category.title}}
                        </a>
                        <ul class="sub-menu col-group">
                            <li v-for="subCategory in category.subCategories" :key="subCategory.id">
                                <a :href="`/shopping/products?sub_category_id=${subCategory.id}`">
                                    {{ subCategory.title }}
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="/shopping/shoppingEvents?type=이벤트">
                            이벤트/혜택
                        </a>
                        <ul class="sub-menu col-group">
                            <li>
                                <a href="/shopping/shoppingEvents?type=이벤트">
                                    이벤트
                                </a>
                            </li>
                            <li>
                                <a href="/shopping/shoppingEvents?type=기획전">
                                    기획전
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="/shopping/faqs">
                            고객지원
                        </a>
                        <ul class="sub-menu col-group">
                            <li>
                                <a href="/shopping/faqs">
                                    FAQ
                                </a>
                            </li>
                            <li>
                                <a href="/shopping/notices">
                                    NOTICE
                                </a>
                            </li>
                            <li>
                                <a href="/shopping/qnas/create">
                                    Q&A
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="right-menu col-group">
                    <li class="search-btn">
                        <span class="icon"></span>

                        <form action="" @submit.prevent="search">
                            <div class="header-search">
                                <input type="text" v-model="form.word">
                                <a href="#" @click.prevent="search">
                                    <i class="xi-arrow-right"></i>
                                </a>
                            </div>
                        </form>
                    </li>

                    <li class="mypage-btn pc">
                        <a href="/shopping/carts"></a>
                    </li>

                    <li class="sitemap-btn mb">
                        <i class="xi-bars"></i>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="site-map">
            <div class="top">
                <div class="top-box col-group">
                    <!-- 로그아웃 상태일 때-->
                    <a href="/shopping/login" class="login-txt" v-if="!user">
                        로그인을 해주세요
                        <i class="xi-angle-right"></i>
                    </a>
                    <!-- //로그아웃 상태일 때-->

                    <!-- 로그인 상태일 때-->
                    <p class="login-txt" v-else>
                        반갑습니다! {{ user.name }}님
                    </p>
                    <!-- //로그인 상태일 때-->

                    <span class="close">
                <i class="xi-close"></i>
            </span>
                </div>
                <ul class="top-menu col-group">
                    <li>
                        <a href="/shopping/carts">
                            <img src="/images/mypage_menu_5.png" alt="">
                            <p>마이페이지</p>
                        </a>
                    </li>
                    <li>
                        <a href="/shopping/carts">
                            <img src="/images/icon_cart_w.png" alt="">
                            <span class="cart-count">{{$page.props.count_cart}}</span>
                            <!-- 장바구니에 담긴 갯수만큼 카운트 됩니다 -->
                            <p>장바구니</p>
                        </a>
                    </li>
                    <li>
                        <a href="/shopping/orders">
                            <img src="/images/mypage_menu_2.png" alt="">
                            <p>주문/배송조회</p>
                        </a>
                    </li>
                    <li>
                        <a href="/shopping/latestProducts">
                            <img src="/images/mypage_menu_6.png" alt="">
                            <p>최근 본 상품</p>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="row-group">
                <div class="mid">
                    <p>
                        카테고리
                    </p>
                    <ul class="mid-menu">
                        <li v-for="category in categories.data" :key="category.id">
                            <p>
                                {{ category.title }}
                                <i class="xi-angle-down"></i>
                            </p>
                            <ul class="sub-menu">
                                <li v-for="subCategory in category.subCategories" :key="subCategory.id">
                                    <a :href="`/shopping/products?sub_category_id=${subCategory.id}`">
                                        {{ subCategory.title }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <p>
                                이벤트/혜택
                                <i class="xi-angle-down"></i>
                            </p>
                            <ul class="sub-menu">
                                <li>
                                    <a href="/shopping/events?type=이벤트">
                                        이벤트
                                    </a>
                                </li>
                                <li>
                                    <a href="/shopping/events?type=기획전">
                                        기획전
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <p>
                                고객지원
                                <i class="xi-angle-down"></i>
                            </p>
                            <ul class="sub-menu">
                                <li>
                                    <a href="/shopping/faqs">
                                        FAQ
                                    </a>
                                </li>
                                <li>
                                    <a href="/shopping/notices">
                                        NOTICE
                                    </a>
                                </li>
                                <li>
                                    <a href="/shopping/qnas">
                                        Q&A
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="btm">
                    <ul class="btm-txt">
                        <li>
                            흙표흙침대 고객센터
                            <strong>080-315-5233</strong>
                        </li>
                        <li>
                            월요일~금요일 09:00~16:30 (토,일,공휴일 휴무)
                        </li>
                        <li>
                            판매입점문의
                            <strong>1577-6674</strong>
                            FAX
                            <strong>051-315-5133</strong>
                        </li>
                    </ul>
                    <ul class="btm-menu col-group">
                        <li>
                            <a href="/shopping/qnas/create">
                                고객센터
                            </a>
                        </li>
                        <li>
                            <a href="/store_search.html" target="_blank">
                                매장안내
                            </a>
                        </li>
                        <li>
                            <a href="/logout">
                                로그아웃
                            </a>
                        </li>
                    </ul>
                    <ul class="col-group family-site">
                        <li>
                            <a href="/shopping">
                                <img src="/images/header_top_logo1.png" alt="">
                                <p>
                                    흙표흙침대
                                    <i class="xi-angle-right"></i>
                                </p>
                            </a>
                        </li>
                        <li>
                            <a href="" target="_blank">
                                <img src="/images/header_top_logo2.png" alt="">
                                <p>
                                    소프라믹
                                    <i class="xi-angle-right"></i>
                                </p>
                            </a>
                        </li>
                        <li>
                            <a href="" target="_blank">
                                <img src="/images/header_top_logo3.png" alt="">
                                <p>
                                    메종바로바우
                                    <i class="xi-angle-right"></i>
                                </p>
                            </a>
                        </li>
<!--                        <li>
                            <a href="" target="_blank">
                                <img src="/images/header_top_logo3.png" alt="">
                                <p>
                                    두도
                                    <i class="xi-angle-right"></i>
                                </p>
                            </a>
                        </li>-->
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
            this.form.get("/shopping/searches");
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
            $('#header .gnb> li').hover(function(){
                $('#header').addClass('toggle');
                $('.sub-menu').removeClass('show');
                $(this).children('.sub-menu').addClass('show');
                if ( $('#header').hasClass('toggle') ) {
                    $('#header').mouseleave(function(){
                        $('#header').removeClass('toggle');
                        $('.sub-menu').removeClass('show')
                    });
                }
            });

            if( ($(document).width()) > 768 ) {

                //헤더 검색버튼 클릭시 검색창 보이기
                $('#header .search-btn .icon').click(function(){
                    $('#header .search-btn').toggleClass('active');
                });

            } else {

                //모바일 검색창
                $('#header .search-btn .icon').click(function(){
                    $('.header-search').toggleClass('active');
                });
            }

            //사이트맵
            $('.sitemap-btn').click(function(){
                $('.site-map').addClass('show');
                $('body').css('overflow', 'hidden');
                $('.header-wrap').addClass('opacity');
            });
            $('.site-map .close').click(function(){
                $('.site-map').removeClass('show');
                $('body').css('overflow', 'unset');
                $('.header-wrap').removeClass('opacity');
            });

            //사이트맵 메뉴 슬라이드
            $('.site-map .mid-menu li> p').click(function(){
                $(this).next('.sub-menu').slideToggle();
                $(this).toggleClass('active');
                if ( $(this).hasClass('active') ) {
                    $(this).children('i').removeClass('xi-angle-down')
                    $(this).children('i').addClass('xi-angle-up')
                } else {
                    $(this).children('i').addClass('xi-angle-down')
                    $(this).children('i').removeClass('xi-angle-up')
                }
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
