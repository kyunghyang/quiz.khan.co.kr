<template>

</template>
<style>
    .guide {
        display:flex; align-items: center; justify-content: center;
        width:100vw; height:100vh;
        font-size:24px; font-weight:bold;
    }
</style>
<script>
export default {
    mounted() {
        // alert("로그인 후 이용해주세요.");

        window.parent.postMessage({ login: true  }, "*");
    }
}
</script>