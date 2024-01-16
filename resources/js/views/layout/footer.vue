<template>
    <div class="footer">
        © {{ start }}-{{ end }} Powered By Management System
    </div>
</template>
<script>

export default {
    data: function () {
        return {
            start: new Date().getFullYear() - 2,
            end: new Date().getFullYear() + 2,
        }
    },
}
</script>
