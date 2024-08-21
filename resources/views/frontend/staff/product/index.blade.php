@extends('frontend.staff.layouts.app')

@section('content')
    <div id="app">
        <div class="container-lg px-4">
            <h1>Product</h1>

            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="row mb-4">
                        <div class="col-sm-6 col-md-4 col-lg-4" v-for="product in products.data" :key="product.id">
                            <div class="card mb-4 w-auto h-auto">
                                <img :src="product.image_url" class="card-img-top object-cover w-full h-36" alt="...">

                                <div class="card-body">
                                    <h5 class="card-title" v-text="product.name"></h5>
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <button class="btn btn-primary btn-sm me-1">
                                                <i class="fa-solid fa-circle-plus"></i>
                                            </button>
                                            <button class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-circle-minus"></i>
                                            </button>
                                        </div>
                                        <span>1000 MMK</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item" :class="{ disabled: !products.links.prev }">
                                    <button class="page-link" @click="fetchProducts(products.links.prev)"
                                        aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </button>
                                </li>
                                <li class="page-item" v-for="page in paginationButtons" :key="page">
                                    <button class="page-link" @click="fetchProductsPage(page)"
                                        :disabled="page === products.meta.current_page"
                                        :class="{ active: page === products.meta.current_page }" v-text="page">
                                    </button>
                                </li>
                                <li class="page-item" :class="{ disabled: !products.links.next }">
                                    <button class="page-link" @click="fetchProducts(products.links.next)" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="card border-secondary mb-3" style="max-width: 18rem;">
                        <div class="card-header bg-transparent border-secondary">Order Items</div>
                        <div class="card-body">
                            <ol class="list-group list-group-numbered">
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Subheading</div>
                                        <div class="btn-group btn-group-sm mt-2" role="group" aria-label="Small button group">
                                            <button type="button" class="btn btn-outline-secondary">
                                                <i class="fa-solid fa-circle-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary">3</button>
                                            <button type="button" class="btn btn-outline-secondary">
                                                <i class="fa-solid fa-circle-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span class="badge text-bg-primary rounded-pill">10000 MMK</span>
                                </li>
                            </ol>
                            <ol class="list-group mt-2 total-cart-item-lists-area">
                                <li class="list-group-item align-items-start">
                                    <div class="d-flex justify-content-between">
                                        <div class="fw-bold">Total Product</div>
                                        <div class="total-amount">2</div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="fw-bold">Total Quntity</div>
                                        <div class="total-amount">5</div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <div class="fw-bold">Total Price</div>
                                        <div class="total-amount">14,000 MMK</div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="fw-bold">Tax</div>
                                        <div class="tax-amount">0 MMK</div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <div class="fw-bold">Total Amount</div>
                                        <div class="total-amount">14,000 MMK</div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                        <div class="card-footer bg-transparent border-secondary">
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary btn-sm" type="button">Order</button>
                                <button class="btn btn-secondary btn-sm" type="button">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('vue.global.js') }}"></script>
    <script src="{{ asset('axios.min.js') }}"></script>

    <script>
        const {
            createApp
        } = Vue;

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
