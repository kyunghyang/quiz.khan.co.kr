<template>
    <main id="main" class="main">
        <section class="main-top">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" v-for="banner in banners.data" :key="banner.id">
                        <div class="bg-cl" :style="`background-color:${banner.color}`"></div>
                        <div class="container">
                            <div class="main-top-le">
                                <span>{{ banner.subtitle }}</span>
                                <p class="GangwonEduAll" style="white-space: pre-line;">{{ banner.title}}</p>
                                <Link :href="`${banner.url ? banner.url : '#'}`" class="radius-btn" :style="`color:${banner.color}; border-color:${banner.color}`">자세히 보기</Link>
                            </div>
                            <div class="main-top-ri">
                                <div class="img-wrap">
                                    <img :src="banner.pc ? banner.pc.url : ''" alt="" class="pc">
                                    <img :src="banner.m ? banner.m.url : ''" alt="" class="mb">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </section>
        <section class="section1">
            <div class="container">
                <div class="side-h2">
                    <span class="num GangwonEduAll">01</span>
                    <span class="GangwonEduAll">도란도란</span>
                    <h2 class="GangwonEduAll">베스트셀러</h2>
                </div>
                <div class="best-wrap">
                    <div class="swiper mySwiper3">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide" v-for="bestProduct in bestProducts.data" :key="bestProduct.id">
                                <div class="img-wrap">
                                    <img :src="bestProduct.img ? bestProduct.img.url : ''" alt="">
                                </div>
                                <div class="ex-wrap">
                                    <h3 class="GangwonEduAll">{{ bestProduct.title }}</h3>
                                    <p class="blue">{{ bestProduct.subtitle }}</p>
                                    <p v-html="bestProduct.summary"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-wrap">
                        <div class="move-btn">
                            <a href="" @click.prevent="showPreview(selectedBestProduct)" class="preview-btn">
                                <i class="xi-play"></i>
                                <i class="xi-play"></i>
                            </a>
                            <span>미리보기</span>
                        </div>
                        <div class="move-btn bl">
                            <Link :href="`/products/${selectedBestProduct.id}`">
                                <i class="xi-arrow-right"></i>
                                <i class="xi-arrow-right"></i>
                            </Link>
                            <span>바로가기</span>
                        </div>
                    </div>
                    <div class="swiper-pagination3"></div>
                </div>
            </div>
        </section>
        <section class="section2">
            <div class="container">
                <div class="side-h2">
                    <span class="num GangwonEduAll">02</span>
                    <span class="GangwonEduAll">도란도란</span>
                    <h2 class="GangwonEduAll">신간추천</h2>
                </div>
                <div class="swiper mySwiper2">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" v-for="recommendProduct in recommendProducts.data" :key="recommendProduct.id">
                            <div class="pdmv-wrap">
                                <div class="img-wrap">
                                    <img :src="recommendProduct.img_recommend ? recommendProduct.img_recommend.url : ''" alt="">
                                </div>
                                <h4>{{recommendProduct.title}}</h4>
                                <div class="btn-wrap">
                                    <div class="move-btn">
                                        <a href="#" @click.prevent="showPreview(recommendProduct)" class="preview-btn">
                                            <i class="xi-play"></i>
                                            <i class="xi-play"></i>
                                        </a>
                                        <span>미리보기</span>
                                    </div>
                                    <div class="move-btn bl">
                                        <Link :href="`/products/${recommendProduct.id}`">
                                            <i class="xi-arrow-right"></i>
                                            <i class="xi-arrow-right"></i>
                                        </Link>
                                        <span>바로가기</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-button-next"><i class="xi-angle-right"></i></div>
                    <div class="swiper-button-prev"><i class="xi-angle-left"></i></div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>

        <event-banners :items="eventBanners.data" />

        <section class="section3">
            <div class="container">
                <div class="side-h2">
                    <span class="num GangwonEduAll">03</span>
                    <span class="GangwonEduAll">도란도란</span>
                    <h2 class="GangwonEduAll">게시판</h2>
                </div>
                <div class="board-wrap">
                    <h3>도란도란 소식</h3>
                    <ul>
                        <li v-for="notice in notices.data" :key="notice.id">
                            <Link :href="`/notices/${notice.id}`">{{ notice.title }}</Link>
                            <span class="days">{{ notice.created_at }}</span>
                        </li>
                    </ul>
                    <a href="/notices"><i class="xi-angle-right"></i></a>
                </div>
            </div>
        </section>

        <preview :product="previewProduct" @close="closePreview" v-if="previewProduct && previewProduct.previews.length > 0" />
    </main>
</template>
<script>
import {Link} from '@inertiajs/inertia-vue';
import EventBanners from "../Components/EventBanners";
import Preview from "../Components/Preview";

export default {
    components: {Preview, EventBanners, Link},

    data() {
        return {
            banners: this.$page.props.banners,
            bestProducts: this.$page.props.bestProducts,
            recommendProducts: this.$page.props.recommendProducts,
            eventBanners: this.$page.props.eventBanners,
            notices: this.$page.props.notices,

            selectedBestProduct: this.$page.props.bestProducts.data[0],

            form: this.$inertia.form({

            }),

            previewProduct: "",
        }
    },

    methods: {
        showPreview(product){
            this.previewProduct = product;
        },
        closePreview(){
            this.previewProduct = "";
        }
    },

    mounted() {
        $(document).ready(function() {
            $(".tab_title li").click(function() {
                var idx = $(this).index();
                $(".tab_title li").removeClass("on");
                $(".tab_title li").eq(idx).addClass("on");
                $(".tab_cont > div").removeClass("on");
                $(".tab_cont > div").eq(idx).addClass("on");
            })
        });

        let self = this;

        var swiper = new Swiper(".mySwiper", {
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
        });

        var swiper = new Swiper(".mySwiper2", {
            slidesPerView: 4,
            spaceBetween: 40,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            loop:true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            breakpoints: {
                1080: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: "auto",
                    loop: true,
                    centeredSlides: true,
                    spaceBetween: 0,
                    grabCursor: true,
                    pagination: {
                        el: ".swiper-pagination",
                        type: "progressbar",
                    },
                },
            }
        });

        var swiper = new Swiper(".banner-sl", {
            pagination: {
                el: ".banner-sl-pagination",
                clickable: true,
            },
            autoplay: {
                delay: 4500,
                disableOnInteraction: false,
            },
        });

        var swiper = new Swiper(".mySwiper3", {
            pagination: {
                el: ".swiper-pagination3",
                clickable: true,
                renderBullet: function (index, className) {
                    let $name = $(".mySwiper3").find(".swiper-slide h3").eq(index).text();
                    return '<span class="' + className + '">' + $name + "</span>";
                },
            },
            on: {
                "slideChange": function(){
                    self.selectedBestProduct = self.bestProducts.data[this.activeIndex];
                }
            }
        });
    }
}
</script>
