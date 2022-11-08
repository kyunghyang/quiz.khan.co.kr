<template>
    <li :class="active ? 'active' : ''">
        <div class="quiz_q" @click.prevent="active = !active">
            <p>
                Q.
                <span>{{ item.title }}</span>
            </p>
            <a href="#" class="btn-explain" @click="showExplain" v-if="active">해설보기</a>
<!--            <a href="">자세히보기</a>-->
        </div>
        <div class="quiz_a" :style="active ? 'display:block' : ''">
<!--            <ul class="quiz_a_top">
                <li>
                    <p>정답률 : <span>{{ item.ratio_correct }}</span>%</p>
                </li>
                <li>
                    <p>총 획득 경험치 : <span>{{ item.answer.point }}</span></p>
                </li>
            </ul>-->
            <div class="quiz_a_main">
                <div class="quiz_exp" v-if="activeExplainPop">
                    <h3>
                        {{ item.title }}
                    </h3>
                    <p>
                        {{ item.explain }}
                    </p>
                </div>
                <div class="quiz_state">
                    <p class="wrong" v-if="item.answer.point === 0 || item.answer.point === '0'">오답입니다. 다음 문제에 도전해보세요.</p>
                    <p class="correct" v-else>정답입니다!  경험치 +<span>{{item.answer.point}}</span> 를 획득하셨습니다!</p>
                </div>
                <ul class="quiz_obj">
                    <li :class="optionClass(item.answer, option)" v-for="option in item.options" :key="option.id">
                        <label for="quiz_obj_1">
                            <input type="radio" id="quiz_obj_1" name="quiz_obj_1" checked disabled>
                            <div class="col-group">
                                <p>
                                    {{ option.title }}
                                </p>

                                <div class="check_icon"><span :class="optionClass(item.answer, option)"><i class="xi-check"></i></span>
                                    <!-- <span class="wrong">
                                        <i class="xi-close"></i>
                                    </span> -->
                                </div>
                            </div>
                        </label>
                    </li>
                </ul>
                <div class="btn_wrap">
                    <a href="#" @click.prevent="activeSharePop = true" class="box-socials-wrap">
                        공유하기
                        <share :path="`/answers/${item.answer.token}`" v-if="activeSharePop" @close="activeSharePop = false"></share>
                    </a>
                </div>
                <div class="quiz_btm">
                    <a :href="item.url" target="_blank">관련 기사 보러가기
                        <span class="point"><i class="xi-arrow-right"></i>{{item.title_url}}</span>
                    </a>
                </div>
            </div>
        </div>
    </li>
</template>
<script>
import {Link} from '@inertiajs/inertia-vue';
import Share from "./Share";
export default {
    components: {Share, Link},
    props: ["item"],
    data(){
        return {
            active: false,
            activeSharePop: false,
            activeExplainPop: false,
        }
    },
    methods: {
        optionClass(answer, option){
            if(option.correct)
                return "correct";

            if(answer.option_id == option.id && answer.point == 0)
                return "wrong";

            return "";
        },

        showExplain(event){
            event.stopPropagation();
            event.preventDefault();

            this.activeExplainPop = !this.activeExplainPop;
        }
    },
    computed: {
    },

    mounted() {

    }
}
</script>
