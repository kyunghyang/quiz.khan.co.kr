<template>
    <div class="container">
        <div class="wrap cont">
            <article class="body">
                <!-- **퀴즈내역** -->
                <div class="mypagequiz khmypage">
                    <h3 class="title">
                        퀴즈내역
                    </h3>
                    <form action="" @click.prevent="filter">
                        <div class="search_box">
                            <input type="text" placeholder="퀴즈 제목으로 검색하세요." v-model="form.word">
                            <button type="submit" class="search_btn">
                                <i class="xi-search"></i>
                            </button>
                        </div>
                    </form>

                    <div class="quizarea">
                        <ul class="quizmenu mypagetab">
                            <li :class="form.correct === '' ? 'active' : ''" @click="form.correct = ''; filter()">
                                전체 <span>{{ countTotal }}</span>
                                <i class="xi-angle-down"></i>
                            </li>
                            <li :class="form.correct === 1 || form.correct === '1' ? 'active' : ''" @click="form.correct = 1; filter()">
                                맞춘 퀴즈 <span>{{ countCorrect }}</span>
                                <i class="xi-angle-down"></i>
                            </li>
                            <li :class="form.correct === 0 || form.correct === '0' ? 'active' : ''" @click="form.correct = 0; filter()">
                                틀린 퀴즈 <span>{{ countIncorrect }}</span>
                                <i class="xi-angle-down"></i>
                            </li>
                        </ul>


                        <div class="quizlist_wrap tab_content active" id="quizmenu_1">
                            <ul class="quiz_a_top" v-if="user">
                                <li>
                                    <p>정답률 : <span>{{ user.ratio_correct }}</span>%</p>
                                </li>
                                <li>
                                    <p>총 획득 경험치 : <span>{{ user.count_quiz_point }}</span></p>
                                </li>
                            </ul>

                            <div class="info_list_area" v-if="items.data.length === 0">
                                <p class="hl">
                                    아직 퀴즈 내역이 없습니다. <br>
                                    오늘의 퀴즈 페이지에서 퀴즈를 풀어보세요!
                                </p>
                            </div>

                            <ul class="quizlist">
                                <question v-for="item in items.data" :key="item.id" :item="item" />
                            </ul>

                            <pagination :meta="items.meta" @paginate="(page) => {form.page = page; filter()}" />

                            <div class="box-bottom-logo">
                                * 제작지원 : <img src="/img/logo_copy.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <!--// **퀴즈내역** -->

            </article>
        </div>
        <!-- // wrap cont -->
    </div>
</template>
<script>
import {Link} from '@inertiajs/inertia-vue';
import Pagination from "../../Components/Pagination";
import Question from "../../Components/Question";

export default {
    components: {Question, Link, Pagination},
    data(){
        return {
            items: this.$page.props.items,
            countTotal : this.$page.props.countTotal,
            countCorrect : this.$page.props.countCorrect,
            countIncorrect : this.$page.props.countIncorrect,
            countTotalPoint : this.$page.props.countTotalPoint,
            user: this.$page.props.user ? this.$page.props.user.data : "",
            form: this.$inertia.form({
                page: 1,
                word: "",
                khan_id: this.$page.props.khan_id,
                correct: this.$page.props.correct
            }),
        }
    },
    methods:{
        filter(){
            this.form.get("/questions", {
                preserveScroll: true,
                preserveState: true,
                onSuccess: (page) => {
                    this.items = page.props.items;
                }
            });
        },

        store(){
            this.form.post("/questions", {
                preserveScroll: true,
                preserveState: true,
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
