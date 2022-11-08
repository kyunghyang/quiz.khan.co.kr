<template>
    <!-- 책미리보기 -->
    <div id="book_preview" class="open">
        <div class="preview-wrap">
            <div class="preview-size">
                <div class="flipbook-top">
                    <h4>{{ product.title }}</h4>
                    <button class="close" @click="close"><i class="xi-close"></i></button>
                </div>
                <div class="flipbook-viewport">
                    <div class="container">
                        <div class="flipbook">
                            <div v-for="(preview, index) in product.previews" :key="index">
                                <img :src="preview ? preview.url : ''" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="book-pagination col-group">
                    <button type="button" class="prev">
                        <i class="xi-angle-left"></i>
                    </button>
                    <div class="bookpage-num">
                        <span class="bookpage-num-now"></span>
                        /
                        <span class="bookpage-num-max"></span>
                    </div>

                    <button type="button" class="next">
                        <i class="xi-angle-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- //책미리보기 -->
</template>
<script>

export default {
    props: ["product"],

    components: {},

    data(){
        return {
            form: this.$inertia.form({

            }),
        }
    },

    methods: {
        setPreview(){
            $("body").css("overflow" , "hidden");

            $(window).ready(function() {
                var page_max = $(".flipbook").children('div').length;

                $('#book_preview .bookpage-num-now').html($(".flipbook").turn('view'));
                $('#book_preview .bookpage-num-max').html(page_max);

                $('.flipbook').turn({
                    display: 'single',
                    acceleration: true,
                    gradients: true,
                    elevation:50,
                    when: {
                        turned: function(e, page) {
                            $('#book_preview .bookpage-num-now').html($(this).turn('view'));
                        }
                    }
                });
            });

            $("#book_preview .prev").click(function(){
                $('.flipbook').turn('previous');
            });
            $("#book_preview .next").click(function(){
                $('.flipbook').turn('next');
            });
        },

        close(){
            $("body").css("overflow" , "unset");
            $( '.flipbook' ).turn( 'destroy' );

            this.$emit("close");
        }
    },

    mounted() {
        this.setPreview();

        // 안드로이드 우측 버튼 비활성
        $(document).bind("contextmenu", function (e) {
            return false;
        });
    },
}
</script>
