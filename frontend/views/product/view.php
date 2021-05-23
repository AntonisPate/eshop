<?php
    use kartik\select2\Select2;
    use yii\web\JsExpression;
    use richardfan\widget\JSRegister;
    use yii\helpers\Url;
    use yii\helpers\Html;
    use backend\models\TranslationFactory;

    $translatorFactory = new TranslationFactory();
    $translator = $translatorFactory->translator;
    $this->title = $model->title;
?>
<div class="large" id="contentId">
    <div class="row product-main">
        <div class="col-sm-5">
            <?= Html::img('http://admin.eshop.local/uploads/' . $model->id . '.jpg', ['style' => 'height: 90%; width: 90%; object-fit: contain']) ?>
        </div>
        <div class="col-sm-5">
            <div class="row">
                <div class="col-sm-12">
                    <h3><?= $model->title?></h3>
                </div>
            </div>
            <div class="row" style="margin-top: 10px;">
                <div id="stars-app">
                </div>
            </div>
            <div class="row" style="margin-top: 10px;">
                <div class="col-sm-12">
                    <h4><?= $model->totalPrice?> €</h4>
                </div>
            </div>
            <div class="row" style="margin-top: 10px;">
                <div class="col-sm-12">
                    <?= $model->description?>
                </div>
            </div>
            <div class="row" style= "margin-top:20%;">
                <div class="col-sm-12">
                    <div id="add-to-cart-app">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row product-description">
        <h3> <?= $translator->translate('Description') ?> </h3>
        <p><?= $model->long_description ?></p>
    </div>

    <div class="row" style="margin-top: 10px; background-color: white;">
        <div class="col-md-12">
            <div id="review-app"></div>
        </div>  
    </div>  
<div>
<?php JSRegister::begin([
    'position' => \yii\web\View::POS_READY
]); ?>
    <script> 
        Vue.component('star-rating', VueStarRating.default);

        $(document).on('click', '#openSidebarBtn', function(e){
            $('#contentId').removeClass('large'); 
        });

        $(document).on('click', '#closeSidebarBtn', function(e){
            $('#contentId').addClass('large'); 
        });

        $(document).on('click', '.main_content', function(e) {
            $('#contentId').addClass('large'); 
        });

        Vue.component('review', {
            props: {
                review: Object
            },
            data: function () {
                return {
                   
                }
            },
            methods: {
                
            },
            computed: {
                
            },
            mounted: function () {

            },
            template: `
            <div class="reviewDiv">
                <div class="row">
                    <div class="col-md-3">
                        <?= $translator->translate('User') ?> <?= $translator->translate('{{review.user_fullname}}') ?>
                    </div> 
                    <div class="col-md-4">
                        {{review.date}}
                    </div> 
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <star-rating :star-size="20" :rating="review.stars" :show-rating="false" :read-only="true" clsss="stars"></star-rating>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p> {{review.content}} </p>
                    </div> 
                </div>
            </div>
            `
        })

        Vue.component('add-review', {
            data: function () {
                return {
                    stars: 0,
                    content: ''
                }
            },
            methods: {
                submitForm: function () {
                    var self = this;
                    var reviewData = {
                        stars: self.stars, 
                        content: self.content,
                        product_id: <?= $model->id ?>
                    };
                    $.ajax({
                        data: reviewData,
                        url: "<?= Url::to(['/reviews/add']) ?>",
                        type: 'post',
                        success: function(data) {
                            self.stars = 0;
                            self.content = '';
                            self.$parent.newReview();
                        },
                    });
                }
            },
            computed: {
                
            },
            mounted: function () {
          
            },
            template: `
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <h3> <?= $translator->translate('Add your review') ?> </h3>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <star-rating :star-size="20" v-model="stars" :show-rating="false"></star-rating>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <textarea v-model="content" cols="50" rows="5"></textarea>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button @click="submitForm" class="submitReviewBtn"> <?= $translator->translate('Add Review')?> </button>
                    </div> 
                </div>
            </div>
            `
        })

        const starsVueApp = new Vue({
            el: '#stars-app',
            data: function () {
                return {
                    rating: <?= $model->rating ?>
                }
            },
            methods: {
            },
            mounted: function () {
                
            },
            template: `
            <div>
                <div class="row">
                    <div class="col-md-12" style="margin-left: 10px;">
                        <star-rating :star-size="20" :rating="rating" :show-rating="false" :read-only="true" clsss="stars"></star-rating>
                    </div> 
                </div>
            </div> 
            `
        })

        const reviewVueApp = new Vue({
            el: '#review-app',
            data: { 
            },
            methods: {
                formHandler: function () {
                    this.showForm = !this.showForm;
                },
                updateReviews: function () {
                    console.log('refresh')
                },
                newReview: function () {
                    var self = this;
                    self.formHandler();
                    $.ajax({
                        url: "<?= Url::to(['/reviews/get-data']) ?>" + '?product_id=' + <?= $model->id ?>,
                        type: 'post',
                        success: function(data) {
                            self.availableReviews = JSON.parse(data);
                        },
                    });
                }
            },
            data: function () {
                return {
                   start: 0,
                   showForm: false,
                   availableReviews: <?= $reviews ?>
                }
            },
            mounted: function () {
                
            },
            template: `
            <div>
                <div class="row" style="margin-bottom: 2%;">
                    <div class="col-md-2">
                        <h3> <?= $translator->translate('Reviews') ?> </h3>
                    </div> 
                    <div class="col-md-6" v-if="!showForm">
                        <button @click="formHandler" class="addReviewBtn"> <?= $translator->translate('Add a review') ?> </button>
                    </div>
                    <div class="col-md-6" v-if="showForm">
                        <button @click="formHandler" class="addReviewBtn"> <?= $translator->translate('Close') ?> x </button>
                    </div> 
                </div> 
                <div class="row" v-if="showForm">
                    <div class="col-md-12">
                        <add-review class="addReviewDiv"></add-review>
                    </div> 
                </div> 

                <div v-for="review in availableReviews">
                      <review :review="review"> </review>
                </div>
            </div> 
            `
        })

        const addToCartVueApp = new Vue({
            el: '#add-to-cart-app',
            data: { 
            },
            methods: {
                reduseQuantity: function () {
                    this.quantity -= this.quantity > 0 ? 1 : 0;
                },
                addQuantity: function () {
                    this.quantity++;
                },
                addToCartHandler: function() {
                    if (this.quantity > 0) {
                        this.addToCart();
                    }
                },
                addToCart: function () {
                    var self = this;
                    var quantityData = {quantity: self.quantity};
                    $.ajax({
                        data: quantityData,
                        url: "<?= Url::to(['/product/add-to-cart']) ?>" + '?id=' + <?= $model->id ?>,
                        type: 'post',
                        success: function(data) {
                            document.getElementById("cartScreenOpacity").classList.add("login");
                            document.getElementById("cartDiv").style.display = "block";
                            self.quantity = 0;
                        },
                    });
                }
            },
            data: function () {
                return {
                    quantity: 0
                }
            },
            mounted: function () {
                
            },
            template: `
            <div>
                <div class="row">
                    <div class="col-md-1">
                        <button class="quantityBtn" @click="reduseQuantity" v-if="quantity > 0"> - </button>
                    </div>
                    <div class="col-md-1">
                        <input class="quantityInput" v-model="quantity"> </input>
                    </div>
                    <div class="col-md-1">
                        <button class="quantityBtn" @click="addQuantity"> + </button>
                    </div>
                    <div class="col-md-6">
                        <button class="addToCartBtn" @click="addToCartHandler"> <?= $translator->translate('Add to cart') ?> </button>
                    </div>
                </div>
            </div> 
            `
        })

    </script> 
 <?php JSRegister::end(); ?>