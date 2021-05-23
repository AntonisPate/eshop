<?php
    use yii\web\JsExpression;
    use richardfan\widget\JSRegister;
    use yii\helpers\Url;
    use yii\helpers\Html;
    use backend\models\TranslationFactory;

    $translatorFactory = new TranslationFactory();
    $translator = $translatorFactory->translator;
    $this->title = $translator->translate('Popular Products'); 
?>
<div class="row" style="margin-top: 10px;">
    <div class="col-md-12">
        <h3> <?= $translator->translate('Popular Products') ?> </h3>
    </div>
</div>
<div class="row" style="margin-top: 10px;">
    <div class="col-md-10">
        <div id="products-app">
        </div>
    </div>
</div>

<?php JSRegister::begin([
    'position' => \yii\web\View::POS_READY
]); ?>
    <script>  
        Vue.use(VueObserveVisibility);
        Vue.component('star-rating', VueStarRating.default);
        
        Vue.component('Product', {
            props: {
                product: Object
            },
            data: function () {
                return {
                    totalPrice: ''
                }
            },
            methods: {
                viewProduct: function () {
                    window.location.href = '/product/view?id=' + this.product.id; 
                },
                updatePrice: function () {
                    var self = this;
                    $.ajax({
                        url: "<?= Url::to(['/product/get-total-price']) ?>" + '?id=' + self.product.id,
                        type: 'post',
                        success: function(data) {
                            self.totalPrice = data;
                        },
                    });
                }
            },
            computed: {
                description: function () {
                    if ('<?= Yii::$app->language?>' == 'en-Us') {
                       return this.product.english_description;
                    } 
                    return  this.product.description;
                },
                title: function () {
                    if ('<?= Yii::$app->language?>' == 'en-Us') {
                       return this.product.english_title;
                    } 
                    return  this.product.title;
                },
            },
            mounted: function () {
                var self = this;
                self.totalPrice = self.product.price;
                $.ajax({
                    url: "<?= Url::to(['/product/get-total-price']) ?>" + '?id=' + self.product.id,
                    type: 'post',
                    success: function(data) {
                        self.totalPrice = data;
                    },
                });
            },
            template: `
            <div class="row product">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12" style="height: 100px;">                          
                            <img class="product-image" style='margin-top: 10px; height: 100%; width: 100%; object-fit: contain' :src="'http://admin.eshop.local/uploads/' + product.id + '.jpg'">
                        </div>
                    </div>
                    <div class="row justify-content-center" style="margin-left: 20px; margin-top: 20px; margin-bottom: 10px;">
                        <star-rating :star-size="25" :rating="product.rating" :show-rating="false" :read-only="true"></star-rating>
                    </div>
                </div>
                <div class="col-md-6 product-information" style="height: 150px;">
                    <div class="row">
                        <div class="col-md-12" style="margin-top: 15px; height: 50px;">
                            <a @click="viewProduct" class="product-title">{{title}}</a>
                        </div>
                        <div class="col-md-12" style="height: 50px;">
                            {{ description }}
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div style="padding-top: 50%; padding-left: 30%;" v-if="product.price == totalPrice">
                        <div class="row">
                            {{ totalPrice }}€
                        </div>
                    </div>
                    <div style="padding-top: 50%; padding-left: 30%;" v-if="product.price != totalPrice">
                        <div class="row" style="color: red;">
                            <?= $translator->translate('From')?> {{ product.price }}€
                        </div>
                        <div class="row" style="color: green;">
                            <?= $translator->translate('Only')?>  {{ totalPrice }}€
                        </div>
                    </div>
                </div>
            </div>
            `
        })

        const vueApp = new Vue({
            el: '#products-app',
            data: { 
            },
            methods: {
                priceFilter: function () {
                    this.error_check_price = false;
                    this.calculateProducts();
                },
                priceCheck: function(from, to) {
                    return !isNaN(parseFloat(from)) && !isNaN(parseFloat(to));
                },
                calculateProducts: function() {
                    this.displayProducts = this.products;
                    if (this.priceCheck(this.filters.from, this.filters.to)) {
                        this.displayProducts = this.products.filter(product => product.price >= this.filters.from && product.price <= this.filters.to);
                    } else {
                        if (this.filters.from != '' && this.filters.to != '') {
                            this.error_check_price = true;
                        }
                    }
                },
                description: function () {
                    if ('<?= Yii::$app->language?>' == 'en-Us') {
                       return this.product.english_description;
                    } 
                    return  this.product.description;
                },
                toggleShow: function() {
                    this.showMenu = !this.showMenu;
                },
                itemClicked: function(item) {
                    this.toggleShow();
                    this.selectedFilter = item; 
                    this.sortProducts(item);
                },
                sortProducts: function(item) {
                    if (item == '<?= $translator->translate('By Price (Ascending)')?>') {
                        this.displayProducts.sort((a,b) => (a.price > b.price) ? 1 : ((b.price < a.price) ? -1 : 0)); 
                    } else if (item == '<?= $translator->translate('By Price (Descending)')?>') {
                        this.displayProducts.sort((a,b) => (a.price < b.price) ? 1 : ((b.price > a.price) ? -1 : 0)); 
                    } else if (item == '<?= $translator->translate('By Stars (Ascending)')?>') {
                        this.displayProducts.sort((a,b) => (a.rating > b.rating) ? 1 : ((b.rating < a.rating) ? -1 : 0)); 
                    } else if (item == '<?= $translator->translate('By Stars (Descending)')?>') {
                        this.displayProducts.sort((a,b) => (a.rating < b.rating) ? 1 : ((b.rating > a.rating) ? -1 : 0)); 
                    }
                    this.updateChildren();
                },
                updateChildren: function() {
                    var self = this;
                    setTimeout(function () {
                        var children = self.$refs.product;
                        for( let i = 0; i < children.length; i++) {
                            children[i].updatePrice();
                        }
                    }, 100); 
                }
            },
            data: function () {
                return {
                    error_check: 0,
                    products: <?= $products ?>,
                    displayProducts: <?= $products ?>,
                    error_check_price: 0,
                    filters: {
                        from: '',
                        to: '',
                    },
                    sortBy: {
                        price: '',
                        stars: '',
                    },
                    showMenu: false,
                    items:  [ 
                        '<?= $translator->translate('By Price (Ascending)')?>',
                        '<?= $translator->translate('By Price (Descending)')?>',
                        '<?= $translator->translate('By Stars (Ascending)')?>',
                        '<?= $translator->translate('By Stars (Descending)')?>'
                    ],
                    selectedFilter: ''
                }
            },
            mounted: function () {
               
            },
            template: `
            <div>
                <div v-for="product in displayProducts">
                    <product :product=product ref="product">
                    </product>
                </div>
            </div> 
            `
        })
    </script>
 <?php JSRegister::end(); ?>