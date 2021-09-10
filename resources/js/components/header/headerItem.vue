<template>
    <li class="nav-item ml-2">
        <a :class="{'nav-link': true, active: active}" aria-current="page" :href="link"><slot></slot></a>
    </li>
</template>

<script>
export default {
    props: ['link', 'active']
}
</script>

<style scoped>

    li {
        background-color: #00000000;
        transition: background-color 200ms;
        border-radius: 4px;
    }

    li:hover{
        background: #4778ac;
    }
</style>