<template>
    <button type="button" class="no-styles" @click="$emit('toggle')">
        <div class="wrapper">
            <div :class="{'off': !status}" class="knob"></div>
            <div class="rail"></div>
        </div>

    </button>
</template>

<script type="text/babel">
    export default {
        props: ['status']
    }
</script>

<style scoped lang="css" type="text/css">

    .wrapper {
        width: 40px;
        height: 20px;
        position: relative;
        background: silver;
        border-radius: 8px;
        border: 1px solid grey;
    }

    .knob {
        position: absolute;
        top: 1px;
        left: 0;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #1c7430;
        transition: transform .5s ease-in-out;
    }

    .knob.off {
        transform: translate3d(22px,0,0);
        background: white;
    }

    .no-styles {
        padding: 0;
        margin: 0;
        background: none;
        border: none;
        outline-style: none;
    }
</style>