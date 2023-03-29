<template>
    <div class="lds-dual-ring"></div>
</template>

<script setup>

</script>

<style>
.lds-dual-ring {
    display: inline-block;
    width: 80px;
    height: 80px;
}

.lds-dual-ring:after {
    content: " ";
    display: block;
    width: 64px;
    height: 64px;
    margin: 8px;
    border-radius: 50%;
    border: 6px solid;
    border-color: #be1d2e transparent;
    animation: lds-dual-ring 1.2s linear infinite;
}

@keyframes lds-dual-ring {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

#progress {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
}

#progress .bar {
    background-color: #29d;
    height: 100%;
    width: 0;
    transition: width .2s ease-out;
}
</style>