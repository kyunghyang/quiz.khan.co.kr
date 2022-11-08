Create.vue<template>

    <div class="container sub">

        <!-- 현재 위치 -->
        <!--
        <div class="breadcrumb">
            <span><a href="https://www.khan.co.kr" title="경향신문">경향신문</a></span>
            <span>
					<a href="#" title="오늘의 퀴즈">
                        <strong>오늘의 퀴즈</strong>
                    </a>
				</span>
        </div>
        -->
        <!-- // 현재 위치 -->


        <!-- section -->
        <div class="section">
            <!-- inner -->
            <div class="inner">
                <!-- cont-main -->
                <div class="cont-main">
                    <div class="title-wrap">
                        <h3 class="sct_tit">{{question.title}}</h3>
                    </div>

                    <!-- ** 오늘의 퀴즈 콘텐츠 ** -->
                    <div class="khquiz khrank mainarea">
                        <div class="tab_content active" id="maintab_1">
                            <div class="khquiz_area">
                                <!-- 정답확인 -->
                                <div class="quizlist">
                                    <div class="quiz_q">
                                        <p>
                                            Q.
                                            <span>{{ question.title }}</span>
                                        </p>
                                        <a href="#" class="btn-explain" @click="activeExplainPop = !activeExplainPop">해설보기</a>
                                    </div>
                                    <div class="quiz_a">
                                        <div class="quiz_a_main">
                                            <div class="quiz_exp" v-if="activeExplainPop">
                                                <h3>
                                                    {{ question.title }}
                                                </h3>
                                                <p>
                                                    {{question.explain}}
                                                </p>
                                            </div>
                                            <div class="quiz_state">
                                                <!--  -->
                                                <p class="correct">{{answer.user.name}}님께서 풀이한 퀴즈입니다.</p>
                                            </div>
                                            <ul class="quiz_obj">
                                                <li :class="optionClass(answer, option)"  v-for="option in question.options" :key="option.id"> <!-- 오답일시 correct 클래스 부여 -->
                                                    <label :for="option.id">
                                                        <input type="radio" :id="option.id" name="quiz_correct" v-if="option.correct" checked disabled>
                                                        <input type="radio" :id="option.id" name="quiz_correct" v-else-if="question.answer.option_id == option.id" checked disabled>
                                                        <input type="radio" :id="option.id" name="quiz_correct" v-else disabled>
                                                        <div class="col-group">
                                                            <p>
                                                                {{ option.title }}
                                                            </p>
                                                            <div class="check_icon">
                                                                <span class="correct">
                                                                    <i class="xi-check"></i>
                                                                </span>
                                                                <!-- <span class="wrong">
                                                                    <i class="xi-close"></i>
                                                                </span> -->
                                                            </div>
                                                        </div>
                                                    </label>
                                                </li>
                                            </ul>
<!--                                            <div class="btn_wrap">
                                                <a href="#" @click.prevent="activeSharePop = true" class="box-socials-wrap">
                                                    공유하기
                                                    <share :path="`/quiz`" v-if="activeSharePop" @close="activeSharePop = false"></share>
                                                </a>
                                            </div>-->
                                        </div>
                                        <div class="quiz_btm">
                                            <a :href="question.url" target="_blank">관련 기사 보러가기
                                                <span class="point"><i class="xi-arrow-right"></i>{{question.title_url}}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- //정답확인 -->


                            </div>
                        </div>
                    </div>
                    <!-- ** //오늘의 퀴즈 콘텐츠 ** -->

                </div>
                <!-- // cont-main -->

            </div>
            <!-- // inner -->
        </div>
        <!-- // section -->
    </div>


</template>
<script>
import {Link} from '@inertiajs/inertia-vue';
import Pagination from "../../Components/Pagination";
import Share from "../../Components/Share";

export default {
    components: {Share, Link, Pagination},
    data(){
        return {
            question: this.$page.props.question.data,
            answer: this.$page.props.answer.data,
            activeExplainPop : false,
            activeSharePop : false,
        }
    },
    methods:{
        optionClass(answer, option){
            if(option.correct)
                return "correct";

            if(answer.option_id == option.id && answer.point == 0)
                return "wrong";

            return "";
        },
    },

    computed: {

    },

    mounted() {

    }
}
</script>
