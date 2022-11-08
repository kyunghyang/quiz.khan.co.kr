<template>
    <div class="left-wrap" id="left_wrap">
        <h2  v-if="user"><span>{{ user.name }}</span>님</h2>
        <h2  v-else><span>게스트</span>님</h2>
        <ul class="mypage-menu">
            <li v-if="!user">
                <a href="/shopping/login">
                    <span class="mypage-icon mb"></span>
                    로그인
                    <i class="xi-angle-right"></i>
                </a>
            </li>
            <li>
                <a href="/shopping/carts" :class="navClass('/shopping/carts')">
                    <span class="mypage-icon mb"></span>
                    장바구니
                    <i class="xi-angle-right"></i>
                </a>
            </li>
            <li v-if="user">
                <a href="/shopping/orders" :class="navClass('/shopping/orders')">
                    <span class="mypage-icon mb"></span>
                    주문/배송관리
                    <i class="xi-angle-right"></i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="/shopping/orders">
                            주문/배송 조회
                        </a>
                    </li>
                    <li>
                        <a href="/shopping/refunds">
                            취소/교환/반품
                        </a>
                    </li>
                </ul>
            </li>
            <li v-if="user">
                <a href="/shopping/likes" :class="navClass('/shopping/likes')">
                    <span class="mypage-icon mb"></span>
                    관심목록
                    <i class="xi-angle-right"></i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="/shopping/likes">
                            관심상품
                        </a>
                    </li>
                    <li>
                        <a href="/shopping/latestProducts">
                            최근 본 상품
                        </a>
                    </li>
                </ul>
            </li>
            <li v-if="user">
                <a href="/shopping/reviews" :class="navClass('/shopping/reviews')">
                    <span class="mypage-icon mb"></span>
                    활동관리
                    <i class="xi-angle-right"></i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="/shopping/reviews">
                            나의 리뷰
                        </a>
                    </li>
                    <li>
                        <a href="/shopping/qnas">
                            A/S신청 및 상담
                        </a>
                    </li>
                </ul>
            </li>
            <li v-if="user">
                <a href="/shopping/users/edit" :class="navClass('/shopping/users/edit')">
                    <span class="mypage-icon mb"></span>
                    회원정보관리
                    <i class="xi-angle-right"></i>
                </a>
            </li>
            <li v-if="user">
                <a href="/logout">
                    <img src="images/icon_logout.png" alt="" class="mb">
                    <span class="pc">
                로그아웃
            </span>
                </a>
            </li>
        </ul>
    </div>
</template>
<script>
    import {Link} from '@inertiajs/inertia-vue';
    export default {
        components: {Link},
        data(){
            return {
                user: this.$page.props.user ? this.$page.props.user.data : "",
                active: false
            }
        },
        methods: {
            navClass(href){
                return href.includes(location.pathname) ? "active" : "";
            }
        }
    }
</script>
