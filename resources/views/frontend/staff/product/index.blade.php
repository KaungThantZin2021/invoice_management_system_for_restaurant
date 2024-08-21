@extends('frontend.staff.layouts.app')

@section('content')
<div id="app">
    <div class="container-lg px-4">
        <h1>Product</h1>
        <div class="row mb-4">
            <div class="col-3" v-for="product in products.data" :key="product.id">
                <div class="card">
                    <img :src="product.image_url" class="card-img-top object-cover w-full h-full" alt="...">

                    <div class="card-body">
                        <h5 class="card-title" v-text="product.name"></h5>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item" :class="{ disabled: !products.links.prev}">
                        <button class="page-link" @click="fetchProducts(products.links.prev)" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </button>
                    </li>
                    <li class="page-item"
                        v-for="page in paginationButtons"
                        :key="page"
                    >
                        <button class="page-link"
                            @click="fetchProductsPage(page)"
                            :disabled="page === products.meta.current_page"
                            :class="{ active: page === products.meta.current_page }"
                            v-text="page"
                        >
                        </button>
                    </li>
                    <li class="page-item" :class="{ disabled: !products.links.next}">
                        <button class="page-link" @click="fetchProducts(products.links.next)" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('vue.global.js') }}"></script>
<script src="{{ asset('axios.min.js') }}"></script>

<script>
    const { createApp } = Vue;

    createApp({
        data() {
            return {
                products: {
                    data: [],
                    links: {},
                    meta: {},
                }
            };
        },
        computed: {
            paginationButtons() {
                const buttons = [];
                const totalPages = this.products.meta.last_page;
                const currentPage = this.products.meta.current_page;

                for (let i = 1; i <= totalPages; i++) {
                    buttons.push(i);
                }

                return buttons;
            }
        },
        methods: {
            fetchProducts(url = '/get-product-list') {
                axios.get(url)
                .then(response => {
                    console.log(response);

                    this.products = response.data.data;
                })
                .catch(error => {
                    console.error("There was an error fetching the products!", error);
                });
            },
            fetchProductsPage(page) {
                const url = `/get-product-list?page=${page}`;
                this.fetchProducts(url);
            }
        },
        mounted() {
            this.fetchProducts();
        }
    }).mount('#app');
</script>
@endsection
