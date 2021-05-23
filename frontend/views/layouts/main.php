<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use kartik\sidenav\SideNav;
use yii\web\JsExpression;
use richardfan\widget\JSRegister;
use backend\models\TranslationFactory;
use yii\helpers\Url;
use common\models\User;
$this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
$session = Yii::$app->session;
if (isset($session['language'])) {
    \Yii::$app->language = $session['language'];
} else {
    \Yii::$app->language = 'el';
}
AppAsset::register($this);
Yii::$app->name = "Eshop";

$translatorFactory = new TranslationFactory();
$translator = $translatorFactory->translator;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
<div class="topnav">
  <button class="openSidebarBtn" id="openSidebarBtn">☰</button>
  <button class="badgeBtn" onclick="window.location.href='/site/index'">ESHOP</button>
  <?php if (empty(Yii::$app->user->id)) { ?>
    <a href="#" id="logBtn"><?= $translator->translate('Log In/Register') ?></a>
  <?php } else { ?>
    <a href="#" id="profileBtn"><?= $translator->translate('Hello') . " " . User::findOne(Yii::$app->user->id)->username?></a>
  <?php } ?>
  <a href="#" id="cartBtn"><?= $translator->translate('Cart') ?></a>
  <input class="searchBar" id="seachBarId" type="text" placeholder=<?= $translator->translate('Search') ?>>
</div> 
<div id="cart-app">
</div>
<div id="log-in-app">
</div>
<div id="profile-app">
</div>
<div class="wrapper">
    <div class="sidebar" id="sidebar">
        <div class="sidebarBadgeDiv">
            <button class="badgeBtn" onclick="window.location.href='/site/index'">ESHOP</button>
        </div>
        <ul>
            <div class="row">
                <div class="col-md-1">
                    <input type="image" id="EngBtn" src="http://admin.eshop.local/uploads/english_flag.png" style="height: 9px;"/>
                </div>
                <div class="col-md-1">
                    <input type="image" id="GrBtn" src="http://admin.eshop.local/uploads/greece_flag.png" style="height: 10px;"/>
                </div>
            </div>
            <li id="closeSidebarBtn" ><a><i class="fas fa-home"></i><?= $translator->translate('Close Menu') ?></a></li>
            <li><a href="/site/index"><i class="fas fa-home"></i><?= $translator->translate('Home') ?></a></li>
            <li><a href="/product/offers"><i class="fas fa-home"></i><?= $translator->translate('Offers') ?></a></li>
            <li><a href="/product/fertilizers"><i class="fas fa-user"></i><?= $translator->translate('Fertilizers') ?></a></li>
            
            <button class="dropdown-btn"><?= $translator->translate('Seeds') ?></button>
            <div class="dropdown-container">
                <li><a href="/product/seeds?subCategoryId=3"><i class="fas fa-address-book"></i><?= $translator->translate('Aromatic') ?></a></li>
                <li><a href="/product/seeds?subCategoryId=4"><i class="fas fa-address-book"></i><?= $translator->translate('Vegetables') ?></a></li>
                <li><a href="/product/seeds?subCategoryId=5"><i class="fas fa-address-book"></i><?= $translator->translate('Cultivation') ?></a></li>
            </div>

            <button class="dropdown-btn"><?= $translator->translate('Plants Trees') ?></button>
            <div class="dropdown-container">
                <li><a href="/product/plants-trees?subCategoryId=7"><i class="fas fa-address-book"></i><?= $translator->translate('Flowers') ?></a></li>
                <li><a href="/product/plants-trees?subCategoryId=8"><i class="fas fa-address-book"></i><?= $translator->translate('Fruiting Trees') ?></a></li>
                <li><a href="/product/plants-trees?subCategoryId=9"><i class="fas fa-address-book"></i><?= $translator->translate('Exhibition Trees') ?></a></li>
            </div>

            <button class="dropdown-btn"><?= $translator->translate('Garden Equipment') ?></button>
            <div class="dropdown-container">
                <li><a href="/product/garden-equipment?subCategoryId=11"><i class="fas fa-address-book"></i><?= $translator->translate('Pruner') ?></a></li>
                <li><a href="/product/garden-equipment?subCategoryId=12"><i class="fas fa-address-book"></i><?= $translator->translate('Watering') ?></a></li>
                <li><a href="/product/garden-equipment?subCategoryId=13"><i class="fas fa-address-book"></i><?= $translator->translate('Saws') ?></a></li>
            </div>

            <button class="dropdown-btn"><?= $translator->translate('Protection Equipment') ?></button>
            <div class="dropdown-container">
                <li><a href="/product/protection-equipment?subCategoryId=16"><i class="fas fa-address-book"></i><?= $translator->translate('Masks') ?></a></li>
                <li><a href="/product/protection-equipment?subCategoryId=15"><i class="fas fa-address-book"></i><?= $translator->translate('Gloves') ?></a></li>
            </div>
        </ul> 
    </div>
    <div class="main_content">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <div class="container" style="margin-top: 5%;">
            <div class="row content">
                <div class="col-12">
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php JSRegister::begin([
    'position' => \yii\web\View::POS_READY
]); ?>
    <script>
        $(document).on('click', '#EngBtn', function(e) {
            window.location.href = '<?= Url::to('/site/change-language') ?>' + '?language=en-Us';
        })

        $(document).on('click', '#GrBtn', function(e) {
            window.location.href = '<?= Url::to('/site/change-language') ?>' + '?language=el';
        })
        
        $(document).on('click', '.main_content', function(e) {
            document.getElementById("sidebar").style.display = "none";
        })

        var input = document.getElementById("seachBarId");

        input.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                window.location.href='<?= Url::to('/product/search')?>' + "?search=" + input.value;
            }
        });

        var dropdown = document.getElementsByClassName("dropdown-btn");
        for (let i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    closeOpen();
                    dropdownContent.style.display = "block";
                }
            });
        }

        function closeOpen() {
            for (let i = 0; i < dropdown.length; i++) {
                var dropdownContent = dropdown[i].nextElementSibling;
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                }
            }
        }

        $(document).on('click', '#openSidebarBtn', function(e){
            document.getElementById("sidebar").style.width = "15%";
            document.getElementById("sidebar").style.display = "block";
        });

        $(document).on('click', '#closeSidebarBtn', function(e){
            document.getElementById("sidebar").style.display = "none";
        });

        $(document).on('click', '#logBtn', function(e){
            document.getElementById("logScreenOpacity").classList.add("login");
            document.getElementById("logDiv").style.display = "block";
        });

        $(document).on('click', '#profileBtn', function(e){
            document.getElementById("screenOpacity").classList.add("login");
            document.getElementById("profileDiv").style.display = "block";
            document.getElementById("cartScreenOpacity").classList.remove("login");
            document.getElementById("cartDiv").style.display = "none";
        });

        $(document).on('click', '#cartBtn', function(e){
            document.getElementById("cartScreenOpacity").classList.add("login");
            document.getElementById("cartDiv").style.display = "block";
            document.getElementById("screenOpacity").classList.remove("login");
            document.getElementById("profileDiv").style.display = "none";
        });

        Vue.use(VueObserveVisibility);

        Vue.component('CartProduct', {
            props: {
                product: Object
            },
            data: function () {
                return {
                    totalPrice: '',
                    displayQuanity: 0,
                    price: 0,
                    imageCheck: true
                }
            },
            methods: {
                removeFromCart(product){
                    this.$parent.removeFromCart(product);
                },
                updatePrice() {
                    this.$parent.updatePrice();
                },
                viewProduct: function () {
                    window.location.href = '/product/view?id=' + this.product.id; 
                },
                reduseQuantity: function () {
                    this.displayQuanity -= this.displayQuanity > 0 ? 1 : 0;
                    this.updateCart();
                },
                addQuantity: function () {
                    this.displayQuanity++;
                    this.updateCart();
                },
                updateCart: function () {
                    var self = this;
                    self.totalPrice = (self.price * self.displayQuanity).toFixed(2);
                    var cartData = {product_id: self.product.id, quantity: self.displayQuanity};
                    $.ajax({
                        data: cartData,
                        url: "<?= Url::to(['/cart/update']) ?>",
                        type: 'post',
                        success: function(data) {
                            self.updatePrice();
                        },
                    });  
                },
                updatePriceDetails: function () {
                    var self = this;
                    $.ajax({
                        url: "<?= Url::to(['/cart/get-product-quantity']) ?>" + '?product_id=' + self.product.id,
                        type: 'post',
                        success: function(data) {
                            self.displayQuanity = data;
                        },
                    });
                    $.ajax({
                        url: "<?= Url::to(['/product/get-total-price']) ?>" + '?id=' + self.product.id,
                        type: 'post',
                        success: function(data) {
                            self.price = data;
                            self.totalPrice = (self.price * self.displayQuanity).toFixed(2);
                        },
                    });
                },
                onVisibilityChanged: function () {
                    var self = this;
                    $.ajax({
                        url: "<?= Url::to(['/cart/get-product-quantity']) ?>" + '?product_id=' + self.product.id,
                        type: 'post',
                        success: function(data) {
                            self.displayQuanity = data;
                        },
                    });
                },
                removeProductHanlder: function () {
                    var self = this;
                    $.ajax({
                        url: "<?= Url::to(['/cart/remove-product']) ?>" + '?product_id=' + self.product.id,
                        type: 'post',
                        success: function(data) {
                            self.removeFromCart(self.product);
                            self.displayQuanity = data;
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
                $.ajax({
                    url: "<?= Url::to(['/cart/get-product-quantity']) ?>" + '?product_id=' + self.product.id,
                    type: 'post',
                    success: function(data) {
                        self.displayQuanity = data;
                    },
                });
                $.ajax({
                    url: "<?= Url::to(['/product/get-total-price']) ?>" + '?id=' + self.product.id,
                    type: 'post',
                    success: function(data) {
                        self.price = data;
                        self.totalPrice = (self.price * self.displayQuanity).toFixed(2);
                    },
                });
            },
            template: `
            <div class="row product">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12" style="height: 100px;"  v-observe-visibility="{callback: onVisibilityChanged}">                          
                            <img v-if="imageCheck" class="product-image" style='margin-top: 10px; height: 100%; width: 100%; object-fit: contain' :src="'http://admin.eshop.local/uploads/' + product.id + '.jpg'">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 product-information" style="height: 150px;">
                    <div class="row">
                        <div class="col-md-8" style="margin-top: 15px; height: 50px;">
                            <a @click="viewProduct" class="product-title">{{title}}</a>
                        </div>
                        <div class="col-md-4" style="margin-top: 15px; height: 50px;">
                            <button @click="removeProductHanlder" class="closeLoginBtn"> <?= $translator->translate('Remove') ?> x </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <button class="quantityBtn" @click="reduseQuantity" v-if="displayQuanity >= 1"> - </button>
                        </div>
                        <div class="col-md-1">
                            <input class="quantityInput" @change="updateCart" v-model="displayQuanity"> </input>
                        </div>
                        <div class="col-md-1">
                            <button class="quantityBtn" style="margin-left: 3px;" @click="addQuantity"> + </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="row">
                        <div class="col-md-21">
                            <div style="padding-top: 30%;">
                                <div style="text-align: center;">
                                    {{price}}€ x {{displayQuanity}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-21">
                            <div style="padding-top: 10%;">
                                <div style="text-align: center;">
                                    {{totalPrice}}€
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `
        })

        const CartVueApp = new Vue({
            el: '#cart-app',
            methods: {
                cartSubmit: function () {
                    window.location.href = "<?= Url::to(['orders/index']) ?>";
                },
                removeFromCart: function (product) {
                    var index = this.availableProducts.indexOf(product);
                    this.availableProducts.splice(index, 1);
                    console.log(this.availableProducts);
                    this.quantities.splice(index, 1);
                    this.updatePrice();
                    this.updateChildren();
                },
                updatePrice: function (product) {
                    var self = this;
                    $.ajax({
                        url: "<?= Url::to(['/cart/get-total-amount']) ?>",
                        success: function(data) {
                            if (data != '') {
                                self.totalCartPrice = data;
                            }
                        },
                    });
                },
                hideCartDiv: function () {
                    document.getElementById("cartScreenOpacity").classList.remove("login");
                    document.getElementById("cartDiv").style.display = "none";  
                },
                visibilityChanged: function ( ) {
                    var self = this;
                    if (self.check) {
                        $.ajax({
                            url: "<?= Url::to(['/cart/get-data']) ?>" + "?user_id=" + <?= Yii::$app->user->id != null ? Yii::$app->user->id : 0?>,
                            success: function(data) {
                                if (data) {
                                    var results = JSON.parse(data).results;
                                    if (results.length != 0) {
                                        self.availableProducts = results.products;
                                        self.quantities = results.quantity;
                                    }
                                }
                            },
                        });
                        $.ajax({
                            url: "<?= Url::to(['/cart/get-total-amount']) ?>",
                            success: function(data) {
                                if (data != '') {
                                    self.totalCartPrice = data;
                                }
                            },
                        });
                    }
                    self.updateChildren();
                },
                updateChildren: function() {
                    var self = this;
                    setTimeout(function () {
                        var children = self.$refs.cartproduct;
                        if (children != undefined) {
                            for( let i = 0; i < children.length; i++) {
                                children[i].updatePriceDetails();
                            }
                        }
                    }, 100); 
                }
            },
            data: function () {
                return {
                    availableProducts: [],
                    quantities: [],
                    check: true,
                    totalCartPrice: 0
                }
            },
            mounted: function () {
                document.getElementById("cartDiv").style.display = "none";
            },
            computed: {
                getTotalPrice: function () {
                    return parseFloat(this.totalCartPrice).toFixed(2);
                }
            },
            template: `
            <div>
                <div @click="hideCartDiv" id="cartScreenOpacity">
                </div>
                <div id="cartDiv" class="cartDiv" v-observe-visibility="{callback: visibilityChanged}">
                    <div class="row logHeader">
                        <div class="col-md-10">
                            <h3> <?= $translator->translate('Cart') ?> </h3>
                        </div>
                        <div class="col-md-2 closeLoginDiv">
                            <div class="row">
                                <button @click="hideCartDiv" class="closeLoginBtn" id="closeCartButton"> <?= $translator->translate('Close') ?> x</button>
                            </div>
                        </div>
                    </div> 
                    <div v-for="(product, index) in availableProducts" v-if="availableProducts.length > 0">
                        <cart-product :product=product ref="cartproduct">
                        </cart-product>
                    </div>
                    <div v-if="availableProducts.length <= 0">
                        <div class="emptyCartDiv">
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $translator->translate('NO PRODUCTS IN THE CART') ?>
                                </div> 
                            </div> 
                        </div> 
                    </div> 
                    <div class="row" v-if="availableProducts.length > 0">
                        <div class="col-md-9">
                            <h3><?= $translator->translate('Total Price')?></h3>
                        </div>
                        <div class="col-md-3">
                            <h3>{{ getTotalPrice }} €</h3>
                        </div>
                    </div>
                    <div class="row placeOrderDiv" v-if="availableProducts.length > 0">
                        <div class="col-md-12">
                            <button class="placeOrderBtn" @click="cartSubmit"> <?=$translator->translate('Place Order') ?> </button>
                        </div> 
                    </div> 
                </div> 
            </div> 
            `
        })

        const ProfileVueApp = new Vue({
            el: '#profile-app',
            methods: {
                hideProfileDiv: function () {
                    document.getElementById("screenOpacity").classList.remove("login");
                    document.getElementById("profileDiv").style.display = "none";  
                },
                logOutHandler: function () {
                    $.ajax({
                        url: "<?= Url::to(['/user/log-out']) ?>",
                        success: function(data) {
                            
                        },
                    });
                },
                updateProfileHandler: function () {
                    var self = this;
                    self.updateError = "";
                    var updateData = {
                        name: self.name,
                        surname: self.surname,
                        email: self.email,
                        updateError: self.updateError,
                    };
                    $.ajax({
                        type: 'post',
                        data: updateData,
                        url: "<?= Url::to(['/user/update']) ?>" + "?id=" + "<?= Yii::$app->user->id ?>",
                        success: function(data) {
                            var result = JSON.parse(data);
                            self.updateError = result.message;
                        },
                    });
                }
            },
            data: function () {
                return {
                    name: "",
                    surname: "",
                    email: "",
                    password: "",
                    updateError: ""
                }
            },
            mounted: function () {
                document.getElementById("profileDiv").style.display = "none";
            },
            template: `
            <div>
                <div @click="hideProfileDiv" id="screenOpacity">
                </div>
                <div id="profileDiv" class="logDiv">
                    <div class="row logHeader">
                        <div class="col-md-8">
                            <h3> <?= $translator->translate('Profile Settings') ?> </h3>
                        </div>
                        <div class="col-md-4 closeLoginDiv">
                            <div class="row">
                                <button @click="hideProfileDiv" class="closeLoginBtn" id="closeLoginButton"> <?= $translator->translate('Close') ?> x</button>
                            </div>
                            <div class="row">
                                <button @click="logOutHandler" class="logoutBtn" id="closeLoginButton"> <?= $translator->translate('Log Out') ?> x</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 logFieldHeader">
                            <?= $translator->translate('Name') ?>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input class="logInputField" v-model="name"></input>
                            </div> 
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-md-12 logFieldHeader">
                            <?= $translator->translate('Surname') ?>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input class="logInputField" v-model="surname"></input>
                            </div> 
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-md-12 logFieldHeader">
                            <?= $translator->translate('Email') ?>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input class="logInputField" v-model="email"></input>
                            </div> 
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-md-12 logFieldHeader">
                            <?= $translator->translate('Password') ?>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="password" class="logInputField" v-model="password"></input>
                            </div> 
                        </div>  
                    </div>
                    <div class="row logInBtnDiv">
                        <div class="col-md-12">
                            <button @click="updateProfileHandler" class="logInBtn"> <?= $translator->translate('Update') ?> </button>
                        </div> 
                    </div> 
                </div>
            </div> 
            `
        })

        const logVueApp = new Vue({
            el: '#log-in-app',
            methods: {
                hideLoginDiv: function () {
                    document.getElementById("logScreenOpacity").classList.remove("login");
                    document.getElementById("logDiv").style.display = "none";  
                },
                displayRegisterForm: function () {
                    this.displayLogin = false;
                },
                displayLoginForm: function () {
                    this.displayLogin = true;
                },
                registerHandler: function () {
                    var self = this;
                    self.registerError = "";
                    var registerData = {
                        username: self.registerUsername,
                        password: self.registerPassword,
                        email: self.registerEmail,
                        name: self.registerName,
                        surname: self.registerSurname,
                    };
                    $.ajax({
                        type: 'post',
                        data: registerData,
                        url: "<?= Url::to(['/user/register']) ?>",
                        type: 'post',
                        success: function(data) {
                            var result = JSON.parse(data);
                            if (result.status) {
                                self.logInError = "";
                                self.displayLogin = true;
                                self.displaySuccessLogin = true;
                            } else {
                                self.registerError = result.message;
                            }
                        },
                    });
                },
                logInHandler: function () {
                    var self = this;
                    self.logInError = "";
                    var logInData = {
                        username: self.logUsername,
                        password: self.logPassword,
                    };
                    $.ajax({
                        type: 'post',
                        data: logInData,
                        url: "<?= Url::to(['/user/log-in']) ?>",
                        type: 'post',
                        success: function(data) {
                            var result = JSON.parse(data);
                            if (result.status) {
                                self.loginError = "";
                            } else {
                                self.loginError = result.message;
                            }
                        },
                    });
                }
            },
            data: function () {
                return {
                    displayLogin: true,
                    registerUsername: "",
                    registerPassword: "",
                    registerEmail: "",
                    registerName: "",
                    registerSurname: "",
                    registerError: "",
                    logUsername: "",
                    logPassword: "",
                    displaySuccessLogin: false,
                    successLoginMessage: "<?= $translator->translate('Your account has been succesfully created.') ?>",
                    loginError: "",
                }
            },
            mounted: function () {
                document.getElementById("logDiv").style.display = "none";
            },
            template: `
            <div>
                <div @click="hideLoginDiv" id="logScreenOpacity">
                </div>
                <div id="logDiv" class="logDiv" v-if="displayLogin">
                    <div class="row logHeader">
                        <div class="col-md-8">
                            <h3> <?= $translator->translate('LOG IN') ?> </h3>
                        </div>
                        <div class="col-md-4 closeLoginDiv">
                            <button @click="hideLoginDiv" class="closeLoginBtn" id="closeLoginButton"> <?= $translator->translate('Close') ?> x</button>
                        </div>
                    </div>
                    <div class="logContent">
                        <div class="row">
                            <div class="col-md-12 logFieldHeader">
                                <?= $translator->translate('Username') ?>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input class="logInputField" v-model="logUsername"></input>
                            </div> 
                        </div>  
                        <div class="row">
                            <div class="col-md-12 logFieldHeader">
                                <?= $translator->translate('Password') ?>
                            </div> 
                        </div> 
                        <div class="row">
                            <div class="col-md-12">
                                <input type="password" class="logInputField"  v-model="logPassword"></input>
                            </div> 
                        </div>
                        <div class="row registerErrorDiv">
                            <div class="col-md-12">
                                {{ loginError }}
                            </div>
                        </div> 
                        <div class="row logInBtnDiv">
                            <div class="col-md-12">
                                <button @click="logInHandler" class="logInBtn"> <?= $translator->translate('Log In') ?> </button>
                            </div> 
                        </div> 
                    </div>
                    <div class="row successMessageDiv" v-if="displaySuccessLogin">
                        <div class="col-md-12">
                            {{ successLoginMessage }}
                        </div> 
                    </div> 
                    <div class="row createAccountDiv">
                        <div class="col-md-11">
                            <button @click="displayRegisterForm" class="createAccountBtn"><?= $translator->translate('Create An Account') ?></button>
                        </div>
                    </div> 
                </div>
                <div id="logDiv" class="logDiv" v-if="!displayLogin">
                    <div class="row logHeader">
                        <div class="col-md-8">
                            <h3> <?= $translator->translate('REGISTER') ?> </h3>
                        </div>
                        <div class="col-md-4 closeLoginDiv">
                            <button @click="hideLoginDiv" class="closeLoginBtn" id="closeLoginButton"> <?= $translator->translate('Close') ?> x</button>
                        </div>
                    </div>
                    <div class="logContent">
                        <div class="row">
                            <div class="col-md-12 logFieldHeader">
                                <?= $translator->translate('Username') ?>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input class="logInputField" v-model="registerUsername"></input>
                            </div> 
                        </div> 
                        <div class="row">
                            <div class="col-md-12 logFieldHeader">
                                <?= $translator->translate('Password') ?>
                            </div> 
                        </div> 
                        <div class="row">
                            <div class="col-md-12">
                                <input type="password" class="logInputField" v-model="registerPassword"></input>
                            </div> 
                        </div> 
                        <div class="row">
                            <div class="col-md-12 logFieldHeader">
                                <?= $translator->translate('Email') ?>
                            </div> 
                        </div> 

                        <div class="row">
                            <div class="col-md-12">
                                <input class="logInputField" v-model="registerEmail"></input>
                            </div> 
                        </div> 
                        <div class="row">
                            <div class="col-md-12 logFieldHeader">
                                <?= $translator->translate('Name') ?>
                            </div> 
                        </div> 
                        <div class="row">
                            <div class="col-md-12">
                                <input class="logInputField" v-model="registerName"></input>
                            </div> 
                        </div> 

                        <div class="row">
                            <div class="col-md-12 logFieldHeader">
                                <?= $translator->translate('Surname') ?>
                            </div> 
                        </div> 
                        <div class="row">
                            <div class="col-md-12">
                                <input class="logInputField" v-model="registerSurname"></input>
                            </div> 
                        </div> 
                        <div class="row registerErrorDiv">
                            <div class="col-md-12">
                                {{ registerError }}
                            </div>
                        </div>
                        <div class="row logInBtnDiv">
                            <div class="col-md-12">
                                <button class="logInBtn" @click="registerHandler"> <?= $translator->translate('Register') ?> </button>
                            </div> 
                        </div>  
                        <div class="row createAccountDiv">
                            <div class="col-md-11">
                                <button @click="displayLoginForm" class="createAccountBtn"><?= $translator->translate('Log In') ?></button>
                            </div>
                        </div> 
                    </div>  
                </div> 
            </div> 
            `
        })

    </script>
 <?php JSRegister::end(); ?>
<?php $this->endBody() ?>
</body>
</html>

<?php $this->endPage() ?>
