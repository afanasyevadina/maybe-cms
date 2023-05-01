<template>
    <nav aria-label="Pagination" v-if="pagination.last_page > 1">
        <ul class="pagination">
            <li class="page-item" :class="{disabled: pagination.current_page <= 1}" @click.prevent="$emit('paginate', pagination.current_page - 1)">
                <a class="page-link" href="#" tabindex="-1">Назад</a>
            </li>
            <li class="page-item" :class="{active: page === pagination.current_page}" v-for="page in pagination.last_page">
                <a class="page-link" href="#" @click.prevent="$emit('paginate', page)">
                    {{ page }} <span class="sr-only" v-if="page === pagination.current_page">(current)</span>
                </a>
            </li>
            <li class="page-item" :class="{disabled: pagination.current_page >= pagination.last_page}" @click.prevent="$emit('paginate', pagination.current_page + 1)">
                <a class="page-link" href="#">Вперед</a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: "Pagination",
    props: {
        pagination: {
            type: Object
        }
    }
}
</script>
