<?php

namespace console\controllers;
use yii\console\Controller;
use Yii;
use yii\helpers\Console;
use common\models\Administrator;
use backend\models\ProductCategory;
use backend\models\Product;
use backend\models\Discount;
use common\models\UserType;

class AppController extends Controller
{
    
    public function actionSetup()
    {
        $this->createUserTypes();
        $this->createAdministrator();
        $this->createCategories();
        $this->createSubCategories();
        $this->addProducts();
        $this->addDiscounts();
    }

    /**
     * Create the default user type models
     * @return void
     */
    private function createUserTypes()
    {
        $user_types = UserType::getTypes();

        foreach ($user_types as $id => $name) {
            $model =  UserType::findOne($id);

            if ($model == null) {
                $model = new UserType();
                $model->id = $id;
            }
            $model->name = $name;

            if ($model->save()) {
                echo "The user type '" . $model->name ."' was created successfully.\n";
            }
        }
    }

    /**
     * Create the administrator user of the application and relate it with the administrator user type
     * @return void
     */
    private function createAdministrator()
    {
        $administratorID = 1;
        $administrator = Administrator::findOne($administratorID);
        
        if ($administrator === null) {
            $administrator = new Administrator([
                'id' => $administratorID,
                'username' => 'admin',
                'name' => 'Administrator',
                'surname' => 'User',
                'email' => 'administrator@local.gr',
            ]);

            $administrator->setPassword('administrator');
            $administrator->generateAuthKey();
            $administrator->activate();
        }
        if ($administrator->save()) {
            echo "Administrator user was created.\n";
        }
    }

    /**
     * Creates the product categories
     * @return void
     */
    private function createCategories()
    {

        $categories = [
            [
                'id' => 1,
                'name' => 'Fertilizers',
                'shortname' => 'Fertilizers',
                'description' => 'Fertilizers description',
            ],
            [
                'id' => 2,
                'name' => 'Seeds',
                'shortname' => 'Seeds',
                'description' => 'Seeds description',
            ],
            [
                'id' => 3,
                'name' => 'Aromatic',
                'shortname' => 'Seeds',
                'description' => 'Aromatic seeds description',
            ],
            [
                'id' => 4,
                'name' => 'Vegetables',
                'shortname' => 'Seeds',
                'description' => 'Vegetables seeds description',
            ],
            [
                'id' => 5,
                'name' => 'Cultivation',
                'shortname' => 'Seeds',
                'description' => 'Cultivation seeds description',
            ],
            [
                'id' => 6,
                'name' => 'Plants Trees',
                'shortname' => 'Plants Trees',
                'description' => 'Plants trees description',
            ],
            [
                'id' => 7,
                'name' => 'Flowers',
                'shortname' => 'Plants Trees',
                'description' => 'Flowers description',
            ],
            [
                'id' => 8,
                'name' => 'Fruiting Trees',
                'shortname' => 'Plants Trees',
                'description' => 'Fruiting trees description',
            ],
            [
                'id' => 9,
                'name' => 'Exhibition Trees',
                'shortname' => 'Plants Trees',
                'description' => 'Exhibition trees description',
            ],
            [
                'id' => 10,
                'name' => 'Garden Equipment',
                'shortname' => 'Garden Equipment',
                'description' => 'Garden equipments description',
            ],
            [
                'id' => 11,
                'name' => 'Pruner',
                'shortname' => 'Garden Equipment',
                'description' => 'Pruner description',
            ],
            [
                'id' => 12,
                'name' => 'Watering',
                'shortname' => 'Garden Equipment',
                'description' => 'Watering description',
            ],
            [
                'id' => 13,
                'name' => 'Saws',
                'shortname' => 'Garden Equipment',
                'description' => 'Saws description',
            ],
            [
                'id' => 14,
                'name' => 'Protection Equipment',
                'shortname' => 'Protection Equipment',
                'description' => 'Protection equipment description',
            ],
            [
                'id' => 15,
                'name' => 'Gloves',
                'shortname' => 'Protection Equipment',
                'description' => 'Gloves description',
            ],
            [
                'id' => 16,
                'name' => 'Masks',
                'shortname' => 'Protection Equipment',
                'description' => 'Masks description',
            ],
        ];

        $productCategories = ProductCategory::find()->all();

        if (!empty($productCategories)) {
            foreach($productCategories as $productCategory) {
                $productCategory->delete();
            }
        }

        foreach($categories as $category) {
            $new_category = new ProductCategory();
            $new_category->id = $category['id'];
            $new_category->primary_name = $category['name'];
            $new_category->shortname = $category['shortname'];
            $new_category->description = $category['description'];

            if ($new_category->save()) {
                echo $new_category->primary_name . " has been saved. \n";
            }
        }
    }

    private function createSubCategories()
    {
        $categories = ProductCategory::find()->all();

        $mainCategories = [];

        foreach($categories as $key => $category) {
            if ($category->primary_name == $category->shortname) {
                $mainCategories [] = $category;
            }
        }

        foreach($categories as $key => $category) {
            if ($category->primary_name == 'fertilizers') {
                $category->sub_category_id = $category->id;
                if ($category->save()) {
                    echo "Sub Category Id for " . $category->id . " has been added\n";
                }
            }
            foreach($mainCategories as $key => $mainCategory) {
                if ($category->shortname == $mainCategory->primary_name && $category->shortname != $category->primary_name) {
                    $category->sub_category_id = $mainCategory->id;
                    if ($category->save()) {
                        echo "Sub Category Id for " . $category->id . " has been added\n";
                    }
                }
            }
        }
    }

    private function addProducts()
    {
        $products_data = [
            [
                'id' => 1,
                'title' => 'Λίπασμα 1',
                'english_title' => 'Fertilizer 1',
                'price' => 200,
                'description' => 'Είναι πολύ καλό λίπασμα',
                'english_description' => 'Is very good fertilizer',
                'long_description' => 'Είναι πολύ καλό λίπασμα για ολο το χρόνο και όλες τις καλλιέργιες',
                'english_long_description' => 'Is very good fertilizer for all the year and for all cultivatations',
                'category_id' => 1,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 2,
                'title' => 'Λίπασμα 2',
                'english_title' => 'Fertilizer 2',
                'price' => 120,
                'description' => 'Λίπασμα για μικρά φυτά',
                'english_description' => 'Fertilizer for small flowers',
                'long_description' => 'Είναι για χρήση σε μικρά φυτά όπως λουλούδια και καλλοπιστικά φυτά',
                'english_long_description' => 'Is better for small plants like flowers and exhibition plants',
                'category_id' => 1,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 3,
                'title' => 'Λίπασμα 3',
                'english_title' => 'Fertilizer 3',
                'price' => 80,
                'description' => 'Οικονομικό λίπασμα',
                'english_description' => 'Economic Fertillizer',
                'long_description' => 'Οικονομικό λίπασμα για όλες τις εποχές του χρόνου',
                'english_long_description' => 'Economic Fertillizer for all time of the year',
                'category_id' => 1,
                'clicks' => 1,
                'rating' => 2
            ],
            [
                'id' => 4,
                'title' => 'Βιολογικό λίπασμα',
                'english_title' => 'Οrganic Fertilizer',
                'price' => 180,
                'description' => 'Βιολογικό λίπασμα από φάρμες',
                'english_description' => 'Οrganic Fertillizer from farms',
                'long_description' => 'Το βιολογικο λίπασμα με ευρωπαικά βραβεια απο φάρμες στη Κρήτη',
                'english_long_description' => 'The award-winning organic fertilizer from cretan farms',
                'category_id' => 1,
                'clicks' => 1,
                'rating' => 5
            ],
            [
                'id' => 5,
                'title' => 'Χημικό λίπασμα',
                'english_title' => 'Chemical Fertilizer',
                'price' => 300,
                'description' => 'Χημικό λίπασμα από φώσφορο',
                'english_description' => 'Chemical Fertillizer from phosphorus',
                'long_description' => 'Ανθεκτικό λίπασμα απο φόσφορο για μεγάλη και δυνατή σοδιά',
                'english_long_description' => 'Very strong fertilizer for big cultivatations',
                'category_id' => 1,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 6,
                'title' => 'Στέβια',
                'english_title' => 'Stevia',
                'price' => 4,
                'description' => 'Η Στέβια ειναι και υποκατάστατο ζάχαρης',
                'english_description' => 'Stevia is a substitute for sugar',
                'long_description' => 'Η Στέβια είναι ενδημικό φυτό στη Νότια Αμερική, ως επί το πλείστον στη Βραζιλία. Είναι ένας μικρός (περίπου 50 εκ. Ψηλός) θάμνος που ευδοκιμεί καλύτερα σε ένα δοχείο. Έχει μαλακά φύλλα, εύκαμπτους τριχωτούς βλαστοούς και παράγει λευκά λουλούδια στην άκρη των βλαστών κατά τη διάρκεια του φθινοπώρου. Μέχρι τώρα, το φυτό καλλιεργείται σε όλο τον κόσμο, ωστόσο, δεν έχει εγκριθεί επισήμως ως τρόφιμο παντού. Η Στέβια παράγει ένα φυσικό γλυκαντικό που υπερβαίνει κατά πολύ τη γλυκύτητα της κοινής ζάχαρης, αλλά δεν είναι τόσο επιβλαβές.',
                'english_long_description' => 'Stevia is indigenous to South America, for the most part to Brasil. The sweetleaf is a small growing (about 50 cm tall) shrub thriving best in a pot. It has soft leaves, flexible, hairy shoots and produces white flowers on the tip of the shoots during autumn. By now, the plant is cultivated all over the world, it has, however, not been officially approved as food-stuff everywhere. The Stevia produces a natural sweetener that surpasses the sweetness of regular sugar by far, but is not that harmful.',
                'category_id' => 3,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 7,
                'title' => 'Βασιλικός Ταϊλάνδης',
                'english_title' => 'Ocimum basilicum “thai”',
                'price' => 8,
                'description' => 'Βασιλικός Ταϊλάνδης',
                'english_description' => 'Stevia is a substitute for sugar',
                'long_description' => 'Ενδημικό στην Ταϊλάνδη και τη Μαλαισία. Δεν μπορεί κανείς να φανταστεί τη βιετναμέζικη και ταϊλανδέζικη κουζίνα χωρίς αυτό το ετήσιο μπαχαρικό φυτό της Άπω Ανατολής που αναπτύσσεται σε ύψος 30-40 cm. Αυτός ο ξεχωριστός βασιλικός μεγαλώνει εύκολα και ζωηρά. Παράγει όμορφες, κόκκινες-ιώδες ταξιανθίες που σχηματίζουν μια υπέροχη αντίθεση με τα φύλλα του. Είναι διακοσμητικό και απαραίτητο για κάθε κήπο με βότανα. Μπορεί να φυτευτεί και σε γλάστρες. Τα φύλλα έχουν μια πικάντικη γεύση με μια ελαφριά νότα γλυκάνισου και ένα εξωτικό άρωμα. Τα φύλλα και οι κορφές μπορούν να συλλεχθούν καθ ‘όλη τη διάρκεια του έτους.',
                'english_long_description' => 'Indigenous to Thailand and Malaysia. One cannot imagine the Vietnamese and Thai cuisine without this annual, Far Eastern spice plant growing to a height of 30-40 cm. The distinct basil grows easily and strongly. It produces beautiful cluster-like, red-violet inflorescences that form a magnificent contrast to its leaves. It adorns every herbal window box and is an eye-catcher for every herb-garden. It should be pot-planted in bunches. Since snails are crazy about basil, pots are ideal for outdoor cultivation, for they can be moved around quickly. The leaves have a spicy flavour with a slight anise note and an exotic scent. Leaves and shoot tips can be harvested throughout the year.',
                'category_id' => 3,
                'clicks' => 1,
                'rating' => 5
            ],
            [
                'id' => 8,
                'title' => 'Κόλιαντρος',
                'english_title' => 'Coriandrum sativum',
                'price' => 4,
                'description' => 'Κόλιαντρος',
                'english_description' => 'Coriandrum sativum',
                'long_description' => 'Ο κόλιαντρος ήταν ενδημικό στις περιοχές της Ανατολικής Μεσογείου. Σήμερα, συναντάται σχεδόν παγκοσμίως. Αυτό το εύρωστο και παραγωγικό, ετήσιο βότανο είναι ένα γνωστό μαγειρικό βότανο από την Ασιατική, Μεσογειακή και Νότιοαμερικάνικη κουζίνα. Η γεύση του είναι έντονη, και ήπια πικάντικη. Το φυτό μπορεί να καλλιεργηθεί ετησίως και να παράγει κάπως στρογγυλά οδοντωτά φύλλα στους μίσχους. Τα λουλούδια εμφανίζονται ήδη μετά από 4-6 εβδομάδες σε άσπρα ή ροζ χρώματα. Μόλις το φυτό παράγει τις συστάδες με τους σφαιροειδείς σπόρους του, πρέπει να στηριχθεί για να μην λυγίζει.',
                'english_long_description' => 'The coriander was indigenous to the Orient, Mediterranean regions. Today, it occurs almost worldwide. This robust and productive, annual herb is a well-known culinary herb from the Asian, Mediterranean and South American cuisine. The flavour is intense, however, of mild-spicy taste. You either love it or you don’t. Coriander translated means “fragrant herb”. The plant can be grown annually and produces somewhat round serrated leaves on the stems. Flowers appear already after 4-6 weeks in the white or pink-coloured umbels. As soon as the plant is producing its globular seed clusters they have to be supported so that they will not bend.',
                'category_id' => 3,
                'clicks' => 1,
                'rating' => 3
            ],
            [
                'id' => 9,
                'title' => 'Σουσάμι Ινδικό',
                'english_title' => 'Sesamum indicum',
                'price' => 4,
                'description' => 'Σουσάμι Ινδικό',
                'english_description' => 'Sesamum indicum',
                'long_description' => 'Το σουσάμι ήταν αρχικά ενδημικό στην Τροπική Αφρική, την Ινδία και την Κίνα. Το ετήσιο φυτό σησαμιού είναι ένα από τα παλαιότερα μπαχαρικά φυτά. Είναι γνωστό στον άνθρωπο για περισσότερα από 3000 χρόνια. Αναπτύσσει διακλαδώσεις και φτάνει σε ύψος περίπου 120-160 cm ανάλογα με την ποικιλία. Τα λαμπερά πράσινα, μαλακά φύλλα είναι λεπτά, με τα λευκά-ροζ λουλούδια να έχουν σχήμα τρομπέτας.',
                'english_long_description' => 'The sesame was originally indigenous to Tropical Africa, India and China. The annual sesame plant is one of the oldest spice plant. It has been known to man for more than 3000 years. It grows branchy and reaches heights of about 1,20-1,60 cm depending on the variety. The bright green, soft leaves are slender, lancet-like with the white-pink flowers being trumpet-like. In Central Europe, the sesame seldomly ripens, because it is too cold here. It nevertheless is a beautiful plant that can be cultivated in a green house or winter garden.',
                'category_id' => 3,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 10,
                'title' => 'Λεμονόχορτο',
                'english_title' => 'Cymbopogon flexuosus',
                'price' => 4,
                'description' => 'Λεμονόχορτο',
                'english_description' => 'Cymbopogon flexuosus',
                'long_description' => 'Το Λεμονόχορτο προέρχεται από τη Νοτιοανατολική Ασία και την Ινδία. Αυτό Το εξωτικό μπαχαρικό φυτό με άρωμα σαν εσπεριδοειδές και ελαφριά πιπεράτη γεύση φτάνει σε ύψος περίπου 50-60 cm ψηλά αν καλλιεργηθεί σε δοχείο και μπορεί να συγκομιστεί φρέσκο όλο το χρόνο.',
                'english_long_description' => 'Lemon grasses originate from South East Asia and India. The exotic spice plant with its citrus-like scent and taste and its light peppery note is growing about 50-60 cm tall in a pot within our regions and can be freshly harvested throughout the year.',
                'category_id' => 3,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 11,
                'title' => 'Sweet Dumpling (Cucurbita maxima)',
                'english_title' => 'Sweet Dumpling (Cucurbita maxima)',
                'price' => 4,
                'description' => 'Διακοσμητικό, Φαγώσιμο, μικρό-μεσαίο μέγεθος',
                'english_description' => 'Sweet Dumpling (Cucurbita maxima)',
                'long_description' => 'Από τις πιο γλυκιές ποικιλίες. Οι καρποί έχουν άσπρη-κρεμ φλούδα με πράσινες ρίγες. Η γλυκιά, τρυφερή, πορτοκαλί σάρκα της την κάνει πολύ δημοφιλή σε συνταγές. Ιδανική για γεμιστή.',
                'english_long_description' => 'One of the sweetest. Fruits have white skin with green stripes. The sweet, tender, orange flesh makes this variety the favorite of many. Suitable for stuffing.',
                'category_id' => 4,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 12,
                'title' => 'Λάχανο κινέζικο Πεκίνου',
                'english_title' => 'Brassica pekinensis',
                'price' => 4,
                'description' => 'Λάχανο κινέζικο Πεκίνου',
                'english_description' => 'Brassica pekinensis',
                'long_description' => '',
                'english_long_description' => '',
                'category_id' => 4,
                'clicks' => 1,
                'rating' => 1
            ],
            [
                'id' => 13,
                'title' => 'Λαχανάκι Βρυξελών',
                'english_title' => 'Brassica oleracea',
                'price' => 4,
                'description' => 'Λαχανάκι Βρυξελών',
                'english_description' => 'Brassica oleracea',
                'long_description' => '',
                'english_long_description' => '',
                'category_id' => 4,
                'clicks' => 1,
                'rating' => 2
            ],
            [
                'id' => 14,
                'title' => 'Rose de Berne – Ντομάτα',
                'english_title' => 'Rose de Berne – Lycopersicon esculentum',
                'price' => 6,
                'description' => 'Rose de Berne – Ντομάτα',
                'english_description' => 'Rose de Berne – Lycopersicon esculentum',
                'long_description' => 'Ιστορική ποικιλία, ελβετική, υπαίθρια. Ιδανική για ψυχρότερα κλίματα με σύντομα καλοκαίρια. Λεπτόφλουδη, ροζ-κόκκινη, 120-180 gr, αρωματική, γλυκιά, για σαλάτες και σάλτσες.',
                'english_long_description' => 'The “Rose of Berne” is an ancient Swiss outdoor tomato. It is undemanding and ideal for colder climates with short summers. It grows to a height of 120 cm, is very productive and takes a bit longer to ripen. Since the bright red-pink coloured fruits (120-180 grams) do have a thin skin, the tomato should only be harvested riply. Every cluster bears 4-6 fruits tasting pleasantly sweet and aromatic. Suitable for direct consumption, also for salads and sauces.',
                'category_id' => 4,
                'clicks' => 1,
                'rating' => 5
            ],
            [
                'id' => 15,
                'title' => 'Tigerella – Ντομάτα',
                'english_title' => 'Tigerella – Lycopersicon esculentum',
                'price' => 6,
                'description' => 'Tigerella – Ντομάτα',
                'english_description' => 'Tigerella – Lycopersicon esculentum',
                'long_description' => 'Ιστορική ποικιλία από την Αγγλία, εξωτική, κόκκινη με κίτρινες ρίγες, 70-100 gr., χυμώδης, νόστιμη.',
                'english_long_description' => 'The stake tomato “Tigerella” is a very robust and productive plant. The red fruits with yellow stripes weigh 70-100 grams. They are juicy and have an excellent flavour. This historical variety is originally from Mexico and was brought to England approximately in 1778. The height of the Tigerella is about 120-180 cm. The tomato is ready for harvest after about 70 days.',
                'category_id' => 4,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 16,
                'title' => 'Σπόροι καλαμποκιού – Golden Bantam',
                'english_title' => 'Corn Seeds – Golden Bantam',
                'price' => 7,
                'description' => 'Corn Seeds – Golden Bantam',
                'english_description' => 'Tigerella – Lycopersicon esculentum',
                'long_description' => 'Αυτή η ποικιλία έκανε το κίτρινο γλυκό καλαμπόκι δημοφιλές όταν ο W. Atlee Burpee την εισήγαγε το 1902. Μέχρι τότε οι άνθρωποι θεωρουσαν μόνο το λευκό καλαμπόκι καλής ποιότητας. Η γεύση του είναι παραδοσιακή γλυκιά και θεωρείται ένα από τα καλύτερα καλαμπόκια φαγητού.',
                'english_long_description' => 'This variety made yellow sweet corn popular. When W. Atlee Burpee introduced it in 1902, people only wanted white corn white signified refinement and quality. It was created by a skilled gardener in Greenfield, Massachusetts who loved to have the earliest corn in town. Golden Bantam quickly rose to the top since it sprouted in cool soil better than all other corns of the time, and growers could make big money with it. The stalks are only 5 ft. tall and often bear two 5 1/2 to 61/2″ long ears apiece. For old- fashioned corn flavor and early plantings, it’s still outstanding. (78 days)',
                'category_id' => 5,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 17,
                'title' => 'Σπόροι καλαμποκιού – Blue Jade',
                'english_title' => 'Corn Seeds – Blue Jade',
                'price' => 7,
                'description' => 'Σπόροι καλαμποκιού – Blue Jade',
                'english_description' => 'Corn Seeds – DF 98704 Blue Jade',
                'long_description' => 'Παραδοσιακή ποικιλία μινιατούρα. Ένα από τα λίγα γλυκά καλαμπόκια που μπορεί να καλλιεργηθεί και σε γλάστρα. Διακοσμητικό με μπλε σπόρους που παίρνουν το χρώμα του νεφρίτη όταν βράζουν. Φαγώσιμο, πολύ γλυκό, βραστό, για σαλάτες, κονσέρβες.',
                'english_long_description' => 'A beautifully colored and unique sweet corn with dark blue kernels. In addition to the pretty ears, Blue Jade is a shorter variety, growing to only three feet, making it one of the only sweet corns that can be grown in a container. When cooked kernels turn to a jade blue color. The steel-blue kernels are plump, sweet and very good. (70-80 days)',
                'category_id' => 5,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 18,
                'title' => 'Klondike Blue Ribbon – Καρπούζι',
                'english_title' => 'Klondike Blue Ribbon',
                'price' => 10,
                'description' => 'Klondike Blue Ribbon – Καρπούζι',
                'english_description' => 'Klondike Blue Ribbon',
                'long_description' => 'Παραδοσιακή παλιά αμερικάνικη ποικιλία από το 1908. Λεπτόφλουδο, με ριγωτή φλούδα, κοκκινόσαρκο. Γεύση γλυκιά και τραγανή. Μπορεί να φτάσει και τα 12 Kg',
                'english_long_description' => '85 days. Perfect heirloom watermelon. A very sweet, scarlet colored flesh with no strings. The fruit has a thin, but tough rind and can weigh up to 12 Kg. Bred by Mr. Porter of California in 1908.',
                'category_id' => 5,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 19,
                'title' => 'Missouri Heirloom – Καρπούζι',
                'english_title' => 'Missouri Heirloom',
                'price' => 10,
                'description' => 'Missouri Heirloom – Καρπούζι',
                'english_description' => 'Missouri Heirloom',
                'long_description' => 'Παραδοσιακή αμερικάνικη σπάνια ποικιλία από το Μιζούρι των ΗΠΑ. Φωτεινή αχοιχτοπράσινη φλούδα και σάρκα σε ανοιχτό πορτοκαλί χρώμα. Γλυκιά, και τραγανή γεύση. Μεσαίο μέγεθος 6-8 kg.',
                'english_long_description' => '90 days. Heirloom from the “Show Me” state. It produces round, 6-8 kg melons with pale green skin and bright golden-yellow flesh that is crisp, sweet and refreshing. A really nice yellow type that is hard to find.',
                'category_id' => 5,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 20,
                'title' => 'Σπόροι ηλίανθων Ruby',
                'english_title' => 'Sunflower Seeds Ruby',
                'price' => 3,
                'description' => 'Σπόροι ηλίανθων Ruby',
                'english_description' => 'Sunflower Seeds',
                'long_description' => 'Εντυπωσιακό ρουμπίνι χρώμα, παράγει 5-15 μεσαίου μεγέθους, μοναδικά χρωματισμένα άνθη ανά στέλεχος. Όμορφο στον κήπο και στο σπίτι.',
                'english_long_description' => 'Stunning Ruby will produce 5-15 medium sized, uniquely coloured blooms per stem if pinched out. Beautiful in the garden or pretty in the home.',
                'category_id' => 7,
                'clicks' => 1,
                'rating' => 5
            ],
            [
                'id' => 21,
                'title' => 'Σπόροι αμάραντων και αποξηραμένων λουλουδιών',
                'english_title' => 'Dried and Everlasting Flowers seeds',
                'price' => 8,
                'description' => 'Σπόροι ηλίανθων Ruby',
                'english_description' => 'Dried and Everlasting Flowers seeds',
                'long_description' => 'Κάθε συσκευασία περιέχει ένα φάκελο με τους ανάλογους σπόρους (καθαροί σπόροι ανώτερης ποιότητας, συσκευασίας προελεύσεως Γερμανίας). Συνοδεύονται από φωτογραφία κατά περίσταση. Είναι διαθέσιμοι όλο το χρόνο, καλοκαίρι, φθινόπωρο, χειμώνα και άνοιξη (ανάλογα με την ποικιλία) και μέχρι εξαντλήσεως των αποθεμάτων.',
                'english_long_description' => 'Seeds of everlasting flowers sweetable for preserving and drying.',
                'category_id' => 7,
                'clicks' => 1,
                'rating' => 2
            ],
            [
                'id' => 22,
                'title' => 'Σπόροι κάκτων και παχυφύτων - Pleiospilos nelii',
                'english_title' => 'Cacti and Succulents - Pleiospilos nelii',
                'price' => 4,
                'description' => 'Σπόροι κάκτων και παχυφύτων',
                'english_description' => 'Cacti and Succulents - Pleiospilos nelii',
                'long_description' => 'Καλλιεργήστε κάκτους και παχύφυτα από σπόρο. Οι σπόροι των κάκτων και παχυφύτων μπορούν να καλλιεργηθούν σε εσωτερικό ή εξωτερικό χώρο όλη τη διάρκεια του έτους. Η συγκεκριμένη συλλογή περιλαμβάνει σπόρους από γνωστά είδη κάκτων και παχυφύτων.',
                'english_long_description' => 'If you have never tried growing Cacti and Succulents from seed, do have a go!',
                'category_id' => 7,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 23,
                'title' => 'Banksia occidentalis',
                'english_title' => 'Banksia occidentalis',
                'price' => 11,
                'description' => 'Banksia occidentalis',
                'english_description' => 'Banksia occidentalis',
                'long_description' => 'Οι σπόροι της Πρωτέας και της Μπάνκσιας είναι αδρανείς και χρειάζονται πολύ ειδικές συνθήκες για να βλαστήσουν. Στη φύση ενεργοποιούνται από τον καπνό μετά από πυρκαγιές. Το Smoke-Primer περιέχει ένα συνδυασμό φυσικών ουσιών που προκύπτουν μετά από «κάπνισμα» και που ξεπερνούν την αδράνεια και διεγείρουν τη βλάστηση των σπόρων.',
                'english_long_description' => 'Proteas and Banksias seeds are dormant and need very specific conditions for germination. The smoke seed primer solution contains a combination of natural substances that overcome dormancy and stimulate seed germination.',
                'category_id' => 7,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 24,
                'title' => 'Teleopea speciosissima',
                'english_title' => 'Teleopea speciosissima',
                'price' => 14,
                'description' => 'Teleopea speciosissima',
                'english_description' => 'Teleopea speciosissima',
                'long_description' => 'Οι σπόροι της Πρωτέας και της Μπάνκσιας είναι αδρανείς και χρειάζονται πολύ ειδικές συνθήκες για να βλαστήσουν. Στη φύση ενεργοποιούνται από τον καπνό μετά από πυρκαγιές. Το Smoke-Primer περιέχει ένα συνδυασμό φυσικών ουσιών που προκύπτουν μετά από «κάπνισμα» και που ξεπερνούν την αδράνεια και διεγείρουν τη βλάστηση των σπόρων.',
                'english_long_description' => 'Proteas and Banksias seeds are dormant and need very specific conditions for germination. The smoke seed primer solution contains a combination of natural substances that overcome dormancy and stimulate seed germination.',
                'category_id' => 7,
                'clicks' => 1,
                'rating' => 5
            ],
            [
                'id' => 25,
                'title' => 'Σπόροι Ροδάκινο Paraguayo',
                'english_title' => 'Saturn Peach, Paraguayo',
                'price' => 3.5,
                'description' => 'Η ροδακινιά(Prunus persica,peach) είναι πυρηνόκαρπο, φυλλοβόλο οπωροφόρο δέντρο που ανήκει στο γένος Προύμνη και στην οικογένεια των Ροδοειδών.',
                'english_description' => 'Saturn Peach, Paraguayo',
                'long_description' => 'Το ύψος του δέντρου φτάνει τα 4,5 μέτρα ο κορμός και οι βλαστοί έχουν φλοιό κοκκινωπού ή πρασινωπού χρώματος. Τα φύλλα του είναι λογχοειδή, πριονωτά στιλπνά, μυτερά στην κορυφή και χρώματος πράσινου, έχουν δε αδένες στη βάση τους από όπου κατά περιόδους εκκρίνουν ένα υγρό σαν ρετσίνι που προσελκύει διάφορα μικρά έντομα. Τα άνθη της ροδακινιάς έχουν 5 ρόδινα πέταλα και φύονται στις μασχάλες των φύλλων και των βλαστών. Οι πρώιμες ποικιλίες έχουν μεγάλα πέταλα και οι όψιμες μικρά. Ο καρπός της ροδακινιάς είναι το ροδάκινο.',
                'english_long_description' => 'Its cultivation is limited principally to warm areas, with Spain – for this very fact – being one of the notable producers of this fruit. The main crop areas are Murcia, Lérida and Aragón. The surface area planted in recent years has been increased enormously due to the fact that it is a product that has been very well received by the consumer, due to its convenience for consumption thanks to its flattened shape and its excellent sweet flavour.  Currently, Murcia is the most important producer in Spain of the Saturn Peach, specifically Vega Alta, and the municipalities of Cieza and Calasparra.',
                'category_id' => 8,
                'clicks' => 1,
                'rating' => 5
            ],
            [
                'id' => 26,
                'title' => 'Σπόροι Ριγέ πορτοκαλί (Citrus aurantium fasciata)',
                'english_title' => 'Striped Orange, Seville-Orange Seeds (Citrus aurantium fasciata)',
                'price' => 5.5,
                'description' => 'Το ώριμο φρούτο ριγέ ανάμεσα σε βαθύ πορτοκαλί και κίτρινο πορτοκάλι, ένδειξη μιας βοτανικής «χίμαιρας», όπου δύο ποικιλίες αναμειγνύονται σε ένα φυτό',
                'english_description' => 'The ripe fruit is randomly striped between deep-orange and yellow-orange, an indication of a botanical `chimera`, where two varieties are intermingled in one plant. The Citrus aurantium `Fasciata` ',
                'long_description' => 'Το ώριμο φρούτο ριγέ ανάμεσα σε βαθύ πορτοκαλί και κίτρινο πορτοκάλι, ένδειξη μιας βοτανικής «χίμαιρας», όπου δύο ποικιλίες αναμειγνύονται σε ένα φυτό.
                Η ιστορική ποικιλία είναι επίσης γνωστή στις ποικιλίες «Virgatum», «Virgolare» ή «Fiamato».
                Το εμπορικό τους σήμα είναι τα κελύφη φρούτων, στα οποία τοποθετούνται "λωρίδες" διαφορετικού πλάτους σαν ένα δεύτερο στρώμα.
                Αυτά είναι αρχικά πράσινα στο χρώμα κατά τη διάρκεια της ωριμότητας, ενώ το κάτω δέρμα γίνεται κίτρινο.
                Όταν είναι πλήρως ώριμα, οι λωρίδες είναι πορτοκαλί, με αποτέλεσμα έναν πορτοκαλοκίτρινο κόκκο.
                Η ανάπτυξη του StripedOrange, Seville-Orange είναι συμπαγής, καλά διακλαδισμένη.
                Τα φύλλα, γεμάτα πλούσια σε αιθέρια έλαια, είναι σκούρα πράσινα και γυαλιστερά, απομονωμένα με κίτρινο μοτίβο. Τα λουλούδια είναι 2-3 εκατοστά μεγάλα και λευκά με έντονη οσμή.',
                'english_long_description' => 'The ripe fruit is randomly striped between deep-orange and yellow-orange, an indication of a botanical `chimera`, where two varieties are intermingled in one plant.
                The Citrus aurantium `Fasciata` was already described in the 16th century and is probably already known since the beginning of 1500.
                The historical variety is also known under the varieties `Virgatum`, `Virgolare` or `Fiamato`.
                Their trademark is the fruit shells, in which "stripes" of different widths are placed like a second layer.
                These are initially green in color during the maturity, while the lower skin turns yellow.
                When fully ripe, the strips are orange, resulting in an orange-yellow grain.
                The growth of the Striped Orange, Seville-Orange is compact, well-branched.
                The leaves, richly filled with essential oils, are dark green and glossy, isolated with a yellow pattern. The flowers are 2-3 cm big and white with an intense smell.',
                'category_id' => 8,
                'clicks' => 1,
                'rating' => 5
            ],
            [
                'id' => 27,
                'title' => 'Κυδωνιά σπόρους',
                'english_title' => 'Quince Seeds (Cydonia oblonga)',
                'price' => 1.5,
                'description' => 'Η κυδωνιά (επιστ. Κυδωνέα η προμήκης, Cydonia oblonga συνώνυμα Cydonia vulgaris Pers. και Pyrus cydonia L.) είναι οπωροφόρο δέντρο της οικογένειας των Ροδοειδών. Η καταγωγή της είναι από την περιοχή του Καυκάσου ή το Ιράν.',
                'english_description' => 'The quince (/ˈkwɪns/; Cydonia oblonga) is the sole member of the genus Cydonia in the family Rosaceae (which also contains apples and pears, among other fruits). It is a small deciduous tree that bears a pome fruit, similar in appearance to a pear',
                'long_description' => 'Πρόκειται για δικοτυλήδονο φυλλοβόλο δέντρο, που φτάνει τα 8 μέτρα (με μέσο ύψος τα 3-4 μ.) σε ύψος και είναι συγγενικό με τη μηλιά και με την αχλαδιά. Είναι επιπολαιόριζο και έχει θυσανωτή ρίζα. Ο κορμός και τα κλαδιά του έχουν γκριζόμαυρο χρώμα και είναι λίγο στρεβλωμένα. Έχει μεγάλα, απλά και δερματώδη φύλλα, με πολλές τρίχες και μεγάλα λευκά ή ρόδινα άνθη, τα οποία είναι μονήρη, με πέντε πέταλα. Το μήκος των φύλλων κυμαίνεται από 6 ως 11 εκατοστά. Ο καρπός του, το κυδώνι, έχει χρώμα κίτρινο προς το χρυσό, όταν είναι ώριμο και έχει σχήμα ακανόνιστο (αχλαδιού). Ορισμένα είδη λεπιδόπτερων τρέφονται με κυδώνια.',
                'english_long_description' => 'The quince (/ˈkwɪns/; Cydonia oblonga) is the sole member of the genus Cydonia in the family Rosaceae (which also contains apples and pears, among other fruits). It is a small deciduous tree that bears a pome fruit, similar in appearance to a pear, and bright golden-yellow when mature. Throughout history the cooked fruit has been used as food, but the tree is also grown for its attractive pale pink blossoms and other ornamental qualities.
                The tree grows 5 to 8 metres (16 to 26 ft) high and 4 to 6 metres (13 to 20 ft) wide. The fruit is 7 to 12 centimetres (2.8 to 4.7 in) long and 6 to 9 centimetres (2.4 to 3.5 in) across.',
                'category_id' => 8,
                'clicks' => 1,
                'rating' => 3
            ],
            [
                'id' => 28,
                'title' => 'Σπόροι ασιατικό αχλάδι',
                'english_title' => 'Asian Pear Seeds - Chinese Sand Pear',
                'price' => 4,
                'description' => 'Αχλάδια είναι δέντρα από γένος Pyrus και φρούτα από εκείνο το δέντρο, εδώδιμος σε μερικά είδη. Τα αχλάδια είναι εγγενή στις συγκρατημένες περιοχές Παλαιός κόσμος, από δυτικό Ευρώπη και ο Βορράς Αφρική ανατολικό δικαίωμα απέναντι Ασία.',
                'english_description' => 'Hardy, Showy Spring Flowers, Edible Fruits, Fall Color, Fast Growth, Shade Tree, Specimen Tree, Adaptable, Cold Tolerant, Espalier The Chinese Sand Pear is larger than most kinds of pear trees, reaching as high as 40 feet, with a rounded crown that may spread 20 feet',
                'long_description' => 'Αχλάδια είναι δέντρα από γένος Pyrus και φρούτα από εκείνο το δέντρο, εδώδιμος σε μερικά είδη. Τα αχλάδια είναι εγγενή στις συγκρατημένες περιοχές Παλαιός κόσμος, από δυτικό Ευρώπη και ο Βορράς Αφρική ανατολικό δικαίωμα απέναντι Ασία. Είναι μέσου μεγέθους δέντρα, φθάνοντας σε 10-17 μ ψηλό, συχνά με έναν ψηλό, στενή κορώνα μερικά είδη είναι θαμνοειδής. φύλλα τακτοποιείται διαδοχικά, απλός, 2-12 εκατ. μακρύς, στιλπνός πράσινος σε μερικά είδη, πυκνά αργυροειδής-τριχωτός σε μερικοί άλλοι η μορφή φύλλων ποικίλλει από ευρύ oval στενό σε λογχοειδές. Τα περισσότερα αχλάδια είναι αποβαλλόμενος, αλλά ένα ή δύο είδη στη Νοτιοανατολική Ασία είναι αειθαλής. 
                λουλούδια είναι άσπρος, σπάνια βαμμένος κίτρινος ή ρόδινος, 2-4 διάμετρος εκατ., και έχει πέντε πέταλα. Όπως αυτό σχετικού μήλο, τα φρούτα αχλαδιών είναι α pome, στην περισσότερη άγρια διάμετρο ειδών 1-4 εκατ., αλλά με μερικές καλλιεργημένες μορφές μέχρι 18 εκατ. μακροχρόνιες και 8 εκατ. ευρύς η μορφή ποικίλλει από globular στα περισσότερα είδη, στην κλασική "αχλάδι-μορφή" Ευρωπαϊκό αχλάδι με μια επιμηκυμένη βασική μερίδα και ένα βολβοειδές τέλος.
                Υπάρχουν περίπου 30 είδη αχλαδιών. Τρία είναι σημαντικά για την παραγωγή εδώδιμων φρούτων, Ευρωπαϊκό αχλάδι Κοινή αχλαδέα καλλιεργημένος κυρίως στην Ευρώπη και Βόρεια Αμερική, Αχλάδι Ya Bretschneideri Pyrus, και Αχλάδι Nashi Pyrifolia Pyrus (επίσης γνωστός ως ασιατικό αχλάδι ή αχλάδι μήλων), και οι δύο που αυξάνονται κυρίως στην ανατολική Ασία. Υπάρχουν χιλιάδες ποικιλίες από αυτά τα τρία είδη.',
                'english_long_description' => 'Hardy, Showy Spring Flowers, Edible Fruits, Fall Color, Fast Growth, Shade Tree, Specimen Tree, Adaptable, Cold Tolerant, Espalier
                The Chinese Sand Pear is larger than most kinds of pear trees, reaching as high as 40 feet, with a rounded crown that may spread 20 feet or more across. In bloom, the tree is almost completely covered with white flowers, putting on a spectacular show in early spring. Individually, the flowers are 1 to 1.5 inches across, with five petals and similar to apple except for having longer pedicels.
                Asian Pears appear more like apple than European pear and have hard, crisp flesh like fruit when ripe, unlike the melting flesh European pears. Also, Asian pears will ripen on trees like apples, but European pears are subject to core breakdown if allowed to ripen fully on-tree. Chinese Sand Pears should be picked when they reach full size and begin to turn yellow. This also prevents maturation of the stone cells which give Sand Pears their gritty texture. Many growers wrap their pears individually in paper and store at room temperature.
                Although children may disagree, Chinese Sand Pear are generally considered inedible unless cooked. The fruits are hard and the flesh is grainy, some say "sandy" in texture. They are most useful for making pies, pear butter, preserves, and for canning.
                Asian Pears were domesticated in China about the same time European Pears were in Europe, 3000 years ago. Pyrus pyrifolia is native to central and southern China and probably the first to be domesticated. Chinese writings dating from 200-1000 BC describe pear propagation and culture. Asian Pears moved from China to Japan, Korea and Taiwan, where they are cultivated commercially today.
                The tree grows 5 to 8 metres (16 to 26 ft) high and 4 to 6 metres (13 to 20 ft) wide. The fruit is 7 to 12 centimetres (2.8 to 4.7 in) long and 6 to 9 centimetres (2.4 to 3.5 in) across.',
                'category_id' => 8,
                'clicks' => 1,
                'rating' => 3
            ],
            [
                'id' => 29,
                'title' => 'Ακακία Ροβίνια',
                'english_title' => 'Black Locust Tree',
                'price' => 15.5,
                'description' => 'Η Ροβίνια η Ψευδοακακία (ή Ψευδακακία) είναι ένα φωτόφιλο φυλλοβόλο δέντρο μεγάλου ύψους και γρήγορου ρυθμού ανάπτυξης.',
                'english_description' => 'The Black Locust is a deciduous light-loving tall and fast growth tree.',
                'long_description' => 'Η Ροβίνια η Ψευδοακακία (ή Ψευδακακία) είναι ένα φωτόφιλο φυλλοβόλο δέντρο μεγάλου ύψους και γρήγορου ρυθμού ανάπτυξης. Χρησιμοποιείται σε πάρκα, σε πλατείες αλλά και για σκίαση στον κήπο. Έχει ωοειδές ακανόνιστο σχήμα, φύλλα πτεροσχιδή και λευκά αρωματικά άνθη από τον Απρίλιο έως τον Ιούνιο, που μοιάζουν στην μορφή με της γλυτσίνιας. Εξαιρετικά δυνατό δέντρο, αντέχει στις καταπονήσεις του αστικού περιβάλλοντος, στην ζέστη και στους ισχυρούς ανέμους. Εάν επιδιωχθεί η συγκράτησή του σε ένα ορισμένο ύψος κλαδεύεται δίχως πρόβλημα. Συγκαταλέγεται στα μελισσοκομικά φυτά και αποτελεί ένα εξαιρετικά χρήσιμο δέντρο για την κηποτεχνία και την αρχιτεκτονική τοπίου.',
                'english_long_description' => 'The Black Locust is a deciduous light-loving tall and fast growth tree. Used in parks, in squares and shaded gardens. Irregular oval shape, imparipinnate leaves and fragrant white flowers from April to June, imitating the form of wisteria. Extremely strong tree, withstand the stresses of the urban environment, the heat and the strong winds. If it is aimed at keeping it at a certain height it is pruned without any problem. It is an extremely useful tree for gardening and landscaping.',
                'category_id' => 9,
                'clicks' => 1,
                'rating' => 3
            ],
            [
                'id' => 30,
                'title' => 'Ιβίσκος Σινικός',
                'english_title' => 'Chinese Hibiscus',
                'price' => 20,
                'description' => 'Ιβίσκος Σινικός Δέντρο (Hibiscus rosa-sinensis) Ύψους 1,00 - 1,20 cm',
                'english_description' => 'Chinese Hibiscus Tree (Hibiscus rosa-sinensis) Height 1.00 -1.20 cm',
                'long_description' => 'Ο Ιβίσκος ο Σινικός (Hibiscus rosa-sinensis) ανήκει σε εκείνη την κατηγορία των ανθοφόρων φυτών που παραδοσιακά κοσμούν τον κήπο ή την αυλή στις θερμές περιοχές του Ελληνικού χώρου. Είναι αειθαλής θάμνος ή μικρό δέντρο, σχήματος ανεστραμένου κώνου, με ωραίου έντονου πράσινου χρώματος γυαλιστερά φύλλα και άνθη μεγάλα μονά, διπλά ή υπέρδιπλα ποικίλων χρωμάτων. Μπορεί να φυτευθεί σε γόνιμο έδαφος, πλούσιο σε οργανική ουσία το οποίο στραγγίζει καλά, ενώ αξιοποιείται εκτός από την φύτευση του στον κήπο ή σε γλάστρες και ως φυτό εσωτερικού χώρου.',
                'english_long_description' => 'Chinese Hibiscus (Hibiscus rosa-sinensis) belongs to that category of flowering plants that traditionally adorn the garden or the yard in the warm regions of the Greek area. It is a evergreen shrub or small tree, inverted cone-shaped, with bright green, glossy leaves and large single, double or super-double flowers. It can be planted on fertile soil, rich in organic matter, which drains well, and is utilized in addition to planting it in the garden or in pots and as an indoor plant.',
                'category_id' => 9,
                'clicks' => 1,
                'rating' => 5
            ],
            [
                'id' => 31,
                'title' => 'Πολύγαλα',
                'english_title' => 'Myrtle-Leaf Milkwort',
                'price' => 25,
                'description' => 'Πολύγαλα Δέντρο Μικρό (Polygala myrtifolia)',
                'english_description' => 'Myrtle-Leaf Milkwort Small Tree (Polygala myrtifolia)',
                'long_description' => 'Το Πολύγαλα (Polygala myrtifolia) είναι ένας αειθαλής πολυετής σφαιρικός θάμνος, που μπορεί να κλαδευτεί για να πάρει το σχήμα μικρού δέντρου, και έχει πράσινα φύλλα και φούξια άνθη από νωρίς την άνοιξη ως αργά το φθινόπωρο, ενώ λουλούδια εμφανίζονται και κατά την διάρκεια του χειμώνα. Αναπτύσσεται σε ηλιόλουστες θέσεις και σε ποικίλους εδαφικούς τύπους. Απαιτεί προστασία από τους παγετούς. Το φυτό Πολύγαλα είναι κατάλληλο και για παραθαλάσσιες φυτεύσεις, ενώ φυτεύεται σε ομάδες, ελεύθερους φράχτες και ζαρντιέρες. ',
                'english_long_description' => 'The Myrtle-Leaf Milkwort (Polygala myrtifolia) is an evergreen perennial shrub - or small tree by training - with green leaves and fuchsia flowers from early spring to late autumn, while flowers also appear during the winter. It grows in sunny places and in various soil types. Requires frost protection. The Myrtle-Leaf Milkwort is also suitable for coastal plantings and it is planted in groups, free fences and planters.',
                'category_id' => 9,
                'clicks' => 1,
                'rating' => 3
            ],
            [
                'id' => 32,
                'title' => 'Μιμόζα Νικαίας',
                'english_title' => 'Silver Wattle Tree',
                'price' => 120,
                'description' => 'Μιμόζα Νικαίας Δέντρο (Acacia dealbata)',
                'english_description' => 'Silver Wattle Tree (Acacia dealbata)',
                'long_description' => 'Η Μιμόζα Νικαίας είναι αειθαλές δέντρο μέσου μεγέθους και γρήγορου ρυθμού ανάπτυξης. Αν και κατάγεται από την Αυστραλία διαδόθηκε και εγκλιματίστηκε πλήρως στις παραμεσόγειες χώρες και στην Ελλάδα. Έχει άφθονη, εντυπωσιακή και εξαιρετικά αρωματική ανθοφορία η οποία στις περιοχές με ήπιο χειμώνα μπορεί να εμφανισθεί από τις αρχές του Φεβρουαρίου - περίοδος στην οποία ελάχιστα φυτά ανθοφορούν. Τα άνθη της είναι σφαιρικά, μοιάζουν με μπονμπόν και έχουν κίτρινο χρώμα. Τα φύλλα της είναι πτερωτά, μπλέ-πράσινα στην αρχή της βλαστικής περιόδου και πράσινα με την πάροδο του χρόνου. Οι καρποί της είναι χεδρωποί πολύσπερμοι, χρώματος καφέ. Πρόκειται για δέντρο εξαιρετικά ανθεκτικό, που δεν παρουσιάζει ιδιαίτερα προβλήματα στην καλλιέργεια. Εκτός από την καλλωπιστική χρήση, η Μιμόζα Νικαίας μπορεί να φυτευθεί και για την παραγωγή ξυλείας αλλά και για την προστασία επικλινών και γυμνών εδαφών από την διάβρωση.',
                'english_long_description' => 'Silver Wattle is an evergreen tree of medium size and rapid growth. Although it origin from Australia,it was widely spread and acclimated to the Mediterranean countries and to Greece. It has abundant, impressive and exceptionally fragrant flowering which in mild winter regions can occur from the beginning of February - a period in which few plants blossom. Its flowers are spherical, resemble a bonbons and are yellow in color. Its leaves are bipinnately compound, blue-green at the beginning of the growing period and green over time. Its legume fruits are brownish, multi-seed. Silver Wattle is a highly resistant tree, with no particular crop problems. In addition to ornamental use, Silver Wattle can also be planted for the production of timber as well as for the protection of sloping and bare soils from erosion.',
                'category_id' => 9,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 33,
                'title' => 'Σωλήνας Άρδευσης Φ20',
                'english_title' => 'Ardenne Pipe Φ20',
                'price' => 0.23,
                'description' => 'Σωλήνας Άρδευσης "Drip" Φ20, με απόχρωση Μαύρη από την Palaplast.',
                'english_description' => 'Ardenne Pipe "Drip" Φ20',
                'long_description' => 'Σωλήνας Άρδευσης "Drip" Φ20, με απόχρωση Μαύρη από την Palaplast.',
                'english_long_description' => 'Ardenne Pipe "Drip" Φ20',
                'category_id' => 11,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 34,
                'title' => 'Λάστιχο επεκτεινόμενο',
                'english_title' => 'Extending Hose',
                'price' => 20,
                'description' => 'Λάστιχο επεκτεινόμενο HOME&CAMP AQUA STRECH 15M, με ταχυσυνδέσμους & εκτοξευτή νερού',
                'english_description' => 'Extending Hose from HOME&CAMP AQUA STRECH 15M',
                'long_description' => 'Λάστιχο επεκτεινόμενο HOME&CAMP AQUA STRECH 15M, με ταχυσυνδέσμους & εκτοξευτή νερού',
                'english_long_description' => 'Extending Hose from HOME&CAMP AQUA STRECH 15M',
                'category_id' => 12,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 35,
                'title' => 'Πριόνι G-ΜΑΝ',
                'english_title' => 'Swaw G-ΜΑΝ κυρτό 30cm ',
                'price' => 24, 
                'description' => 'Swaw G-ΜΑΝ 30cm',
                'english_description' => 'Swaw G-ΜΑΝ 30cm',
                'long_description' => 'Πολύ ποιοτικό σπαστό πριόνι 30cm της G-MAN. Εξ’ολοκλήρου κατασκευή στην Σουηδία',
                'english_long_description' => 'Swaw G-ΜΑΝ 30cm made in Sweeden',
                'category_id' => 13,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 36,
                'title' => 'Πριόνι σπαστό SHARK',
                'english_title' => 'Shark SAW',
                'price' => 30, 
                'description' => 'Πριόνι σπαστό SHARK SAW 21cm',
                'english_description' => 'SHARK SAW 21cm',
                'long_description' => 'Πολύ ποιοτικό σπαστό πριόνι της SHARK SAW. Εξ’ολοκλήρου κατασκευή στην Ιαπωνία',
                'english_long_description' => 'Swaw G-ΜΑΝ 30cm made in Japan',
                'category_id' => 13,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 37,
                'title' => 'Γυαλιά ψεκασμού',
                'english_title' => 'Spray glasses',
                'price' => 4, 
                'description' => 'Γυαλιά προστασίας, διαφανή, για υγρά και σκόνη',
                'english_description' => 'Spray glasses for all uses',
                'long_description' => 'Γυαλιά προστασίας, διαφανή, για υγρά και σκόνη',
                'english_long_description' => 'Spray glasses for all uses',
                'category_id' => 16,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 38,
                'title' => 'Προστατευτικό προσώπου',
                'english_title' => 'Face protector',
                'price' => 12, 
                'description' => 'Προστατευτικό προσώπου με τζάμι + 5 ανταλλακτικά',
                'english_description' => 'Face protector with glass + 5 spare parts',
                'long_description' => 'Ασπίδα προστασίας προσώπου ρυθμιζόμενο δέσιμο. Κατάλληλο για εργαζόμενους στην εστίαση.',
                'english_long_description' => 'Adjustable fastening face protection shield. Suitable for catering employees.',
                'category_id' => 16,
                'clicks' => 1,
                'rating' => 4
            ],
            [
                'id' => 39,
                'title' => 'Γάντια νιτριλίου',
                'english_title' => 'Nitrile gloves',
                'price' => 1, 
                'description' => 'Γάντια νιτριλίου 50g μπλε | 1 ζεύγος',
                'english_description' => 'Nitrile gloves 50g blue | 1 pair',
                'long_description' => 'Προσφέρουν προστασία σε όλες τις εργασίες και παράλληλα αφήνουν το χέρι να αναπνέει μέσα από την πλεκτή επάνω επιφάνεια.',
                'english_long_description' => 'They offer protection in all tasks and at the same time allow the hand to breathe through the knitted upper surface.',
                'category_id' => 15,
                'clicks' => 1,
                'rating' => 4
            ],
        ];

        $oldProducts = Product::find()->all();

        foreach ($oldProducts as $product) {
            $product->delete();
        }

        foreach ($products_data as $key => $data) {
            $product = Product::findOne($data['id']);
            if (empty($product)) {
                $product = new Product();
                $product->id = $data['id'];
                $product->title = $data['title'];
                $product->english_title = $data['english_title'];
                $product->price = $data['price'];
                $product->description = $data['description'];
                $product->english_description = $data['english_description'];
                $product->long_description = $data['long_description'];
                $product->english_long_description = $data['english_long_description'];
                $product->category_id = $data['category_id'];
                $product->clicks = $data['clicks'];
                $product->rating = $data['rating'];
                if ($product->save()) {
                    echo "Product " . $product->title . " has been added\n";
                }
            }
        }
    }

    private function addDiscounts()
    {
        $discount_data = [
            [
                'id' => 1,
                'product_category_id' => 8,
                'discount_percentance' => 10,
                'from' => '2020-08-1',
                'to' => '2020-08-1',
                'message' => 'Message',
                'title' => 'Karpofora 10%',
            ]
        ];

        $oldDiscounts = Discount::find()->all();

        foreach ($oldDiscounts as $discount) {
            $discount->delete();
        }

        foreach ($discount_data as $key => $data) {
            $product = Discount::findOne($data['id']);
            if (empty($product)) {
                $discount = new Discount();
                $discount->id = $data['id'];
                $discount->product_category_id = $data['product_category_id'];
                $discount->discount_percentance = $data['discount_percentance'];
                $discount->from = $data['from'];
                $discount->to = $data['to'];
                $discount->message = $data['message'];
                $discount->title = $data['title'];
                if ($discount->save()) {
                    echo "Discount " . $discount->title . " has been added\n";
                }
            }
        }
    }
}