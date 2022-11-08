<template>
    <div class="container">
        <div class="wrap cont">
            <article class="body">

                <!-- **뉴스 소비량** -->
                <div class="mypagenews khmypage">
                    <h3 class="title">
                        뉴스 소비량
                    </h3>

<!--                    <div class="info_list_area">
                        <p class="hl">
                            아직 완독한 기사 내용이 없습니다. <br>
                            뉴스를 끝까지 완독해보세요!
                        </p>
                    </div>-->

                    <ul class="newstotal">
                        <li>
                            <h4>
                                <span class="count_num">{{ countTotal }}</span>개
                            </h4>
                            <p>
                                완독한 기사
                            </p>
                        </li>
                        <li>
                            <h4>
                                <span class="count_num2">{{ countTotalText }}</span>
                            </h4>
                            <p>
                                읽은 글자 수
                            </p>
                        </li>
                        <li>
                            <h4>
                                <span class="count_num3">{{ countTotalBook  }}</span>권
                            </h4>
                            <p>
                                책으로 환산
                            </p>
                        </li>
                    </ul>

                    <h3 class="title">
                        분야별 소비량
                    </h3>

                    <div class="newsarea">
                        <div class="newstab_area">
                            <ul class="newstab mypagesubtab">
                                <li :class="form.category === category.code ? 'active' : ''" v-for="category in categories.data" :key="category.id" @click="form.category = category.code; filter();">
                                    {{ category.title }}
                                </li>
                            </ul>
                        </div>

                        <div class="tab_content active" id="newstab_1">
                            <ul class="newstotal">
                                <li>
                                    <h4>
                                        <span class="count_num">{{ countCategoryTotal }}</span>개
                                    </h4>
                                    <p>
                                        완독한 기사
                                    </p>
                                </li>
                                <li>
                                    <h4>
                                        <span class="count_num2">{{ countCategoryTotalText }}</span>
                                    </h4>
                                    <p>
                                        읽은 글자 수
                                    </p>
                                </li>
                                <li>
                                    <h4>
                                        <span class="count_num3">{{ countCategoryTotalBook }}</span>권
                                    </h4>
                                    <p>
                                        책으로 환산
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="box-bottom-logo">
                        * 제작지원 : <img src="/img/logo_copy.png" alt="">
                    </div>
                </div>
                <!--// **뉴스 소비량** -->

            </article>
        </div>
        <!-- // wrap cont -->
    </div>

</template>
<script>
import {Link} from '@inertiajs/inertia-vue';
import Pagination from "../../Components/Pagination";

export default {
    components: {Link, Pagination},

    data(){
        return {
            items: this.$page.props.items,
            countTotal: this.$page.props.countTotal,
            countTotalText: this.$page.props.countTotalText,
            countTotalBook: this.$page.props.countTotalBook,
            countCategoryTotal: this.$page.props.countCategoryTotal,
            countCategoryTotalText: this.$page.props.countCategoryTotalText,
            countCategoryTotalBook: this.$page.props.countCategoryTotalBook,
            categories: this.$page.props.categories,

            form: this.$inertia.form({
                page: 1,
                khan_id: this.$page.props.khan_id,
                category: this.$page.props.category,
            })
        }
    },

    methods:{
        filter(){
            this.form.get("/readHistories", {
                preserveScroll: true,
                preserveState: false,
                onSuccess: (page) => {
                    this.items = page.props.items;
                }
            });
        },
    },

    mounted() {

    }
}
</script>
