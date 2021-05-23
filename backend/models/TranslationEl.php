<?php
namespace backend\models;

use Yii;
use yii\base\Model;

class TranslationEl extends Model
{
    public function translate($string)
    {
        if ($string != null && $string != '') {
            $translations = $this->translations;
            foreach($translations as $key => $translation) {
                if ($key == $string) {
                    return $translation;
                }
            }
        }
        return $string;
    } 

    public function getTranslations()
    {
        return [
            'Select a Category ...' => 'Διαλέξτε μία κατηγορία ...',
            'Title' => 'Τίτλος',
            'Price' => 'Τιμή',
            'Description' => 'Περιγραφή',
            'Category' => 'Κατηγορία',
            'Image' => 'Εικόνα',
            'Save' => 'Αποθήκευση',
            'Fertilizers' => 'Λιπάσματα',
            'Seeds' => 'Σπόροι',
            'Aromatic' => 'Αρωματικά',
            'Vegetables' => 'Λαχανικά',
            'Cultivation' => 'Καλλιέργεια',
            'Plants Trees' => 'Φυτά Δέντρα',
            'Flowers' => 'Λουλούδια',
            'Fruiting Trees' => 'Καρποφόρα Δέντρα',
            'Exhibition Trees' => 'Καλλωπιστικά Δέντρα',
            'Garden Equipment' => 'Είδη κήπου',
            'Pruner' => 'Σωληνώσεις',
            'Watering' => 'Ποτιστικά',
            'Saws' => 'Πριόνια',
            'Protection Equipment' => 'Είδη Προστασίας',
            'Gloves' => 'Γάντια',
            'Masks' => 'Μάσκες',
            'Products' => 'Προιόντα',
            'Product' => 'Προιόν',
            'Create Product' => 'Δημιουργία Προιόντος',
            'Update' => 'Ενημέρωση',
            'Discount' => 'Έκπτωση',
            'Discounts' => 'Eκπτώσεις',
            'Rating' => 'Βαθμολογία',
            'Create Discount' => 'Δημιουργία Έκπτωσης',
            'Message' => 'Μήνυμα',
            'From' => 'Από',
            'To' => 'Εώς',
            'Product Category' => 'Κατηγορία Προιόντος',
            'Discount Percentance' => 'Ποσοστό Έκπτωσης',
            'Logout' => 'Αποσύνδεση',
            'Home' => 'Αρχική Σελίδα',
            'Search' => 'Αναζήτηση',
            'Log In' => 'Είσοδος',
            'Price Range' => 'Περιοχή Τιμών',
            'The Product was deleted successfully' => 'Το προιόν διεφράφει με επιτυχία',
            'The Product was updated successfully' => 'Το προιόν ενημερώθηκε με επιτυχία',
            'The Product was added successfully' => 'Το προιόν προστέθηκε με επιτυχία',
            'The Discount was added successfully' => 'Η έκπτωση προστέθηκε με επιτυχία',
            'The Discount was updated successfully' => 'Η έκπτωση ενημερώθηκε με επιτυχία',
            'The Discount was deleted successfully' => 'Η έκπτωση διεφράφει με επιτυχία',
            'English Title' => 'Αγγλικός Τίτλος',
            'English Description' => 'Αγγλική Περιγραφή',
            'Long Description' => 'Μεγάλη Περιγραφή',
            'English Long Description' => 'Αγγλική Μεγάλη Περιγραφή',
            'Close Menu' => 'Κλείσιμο Μενού',
            'Cart' => 'Καλάθι',
            'Profile Settings' => 'Ρυθμίσεις Προφίλ',
            'Close' => 'Κλείσιμο',
            'Log Out' => 'Αποσύνδεση',
            'Name' => 'Όνομα',
            'Surname' => 'Επίθετο',
            'Password' => 'Κωδικός Πρόσβασης',
            'Hello' => 'Γειά σου',
            'Log In/Register' => 'Σύνδεση/Εγγραφή',
            'Log In' => 'Σύνδεση',
            'LOG IN' => 'ΣΥΝΔΕΣΗ',
            'Create An Account' => 'Δημιουργία Προφιλ',
            'REGISTER' => 'ΕΓΓΡΑΦΗ',
            'Register' => 'Εγγραφή',
            'Add to cart' => 'Προσθήκη',
            'NO PRODUCTS IN THE CART' => 'ΔΕΝ ΥΠΑΡΧΟΥΝ ΠΡΟΙΟΝΤΑ ΣΤΟ ΚΑΛΑΘΙ ΣΑΣ',
            'Remove' => 'Αφαίρεση',
            'Total Price' => 'Τελική τιμή',
            'Place Order' => 'Αποστολή Παραγγελίας',
            'Sort By' => 'Ταξινόμηση Κατά',
            'By Price (Ascending)' => 'Τιμή (Αύξουσα)',
            'By Price (Descending)' => 'Τιμή (Φθίνουσα)',
            'By Stars (Ascending)' => 'Αξιολόγηση (Αύξουσα)',
            'By Stars (Descending)' => 'Αξιολόγηση (Φθίνουσα)',
            'Order Information' => 'Πληροφορίες Παραγγελίας',
            'Shipping Address' => 'Διεύθυνση Αποστολής',
            'Information' => 'Πληροφορίες',
            'Finish Order' => 'Ολοκλήρωση Παραγγελίας',
            'Transmition Type' => 'Μέθοδος Αποστολής',
            'Select a tranmition type ...' => 'Επιλέξτε ενα τρόπο αποστολής ...',
            'Payment' => 'Πληρωμή',
            'Select a payment type ...' => 'Επιλέξτε ενα τρόπο πληρωμής ...',
            'Pay with card' => 'Πληρωμη μέσω κάρτας',
            'Immediate bank transfer' => 'Άμεση τραπεζική μεταφορά',
            'Pay on delivery' => 'Αντικαταβολή',
            'Received from store' => 'Παραλαβή απο το κατάστημα',
            'Shippment' => 'Αποστολή',
            'Address' => 'Διεύθυνση',
            'City' => 'Πόλη',
            'Postal Code' => 'Ταχυδρομικός κώδικας',
            'Success' => 'Επιτυχία',
            'Phone Number' => 'Τηλέφωνο',
            'Your order has been complete successfully' => 'Η παραγγελία σας εχει ολοκληρωθεί με επιτυχία',
            'User' => 'Χρήστης',
            'Status' => 'Κατάσταση',
            'Received' => 'Λήφθηκε',
            'Sent' => 'Απεσταλμένη',
            'Delivered' => 'Παραδόθηκε',
            'Cancelled' => 'Ακυρώθηκε',
            'Completed' => 'Ολοκληρώθηκε',
            'Date' => 'Ημερομηνία',
            'The order was deleted successfully' => 'Η παραγγελία διεφράφει με επιτυχία',
            'Orders' => 'Παραγγελίες',
            'Set Send' => 'Απεσταλμένη',
            'Set Delivered' => 'Παραδόθηκε',
            'Set Cancelled' => 'Ακύρωση',
            'Set Completed' => 'Ολοκληρώθηκε',
            'The order was completed successfully' => 'Η παραγγελία σας εχει ολοκληρωθεί με επιτυχία',
            'The order was cancelled successfully' => 'Η παραγγελία σας εχει ακυρωθεί με επιτυχία',
            'The order was delivered successfully' => 'Η παραγγελία σας εχει παραδοθεί με επιτυχία',
            'The order was sent successfully' => 'Η παραγγελία σας εχει αποσταλεί με επιτυχία',
            'Guest' => 'Επισκέπτης',
            'Add your review' => 'Προσθέστε την αξιολόγησή σας',
            'Add a review' => 'Προσθέστε μια αξιολόγηση',
            'Reviews' => 'Αξιολογήσεις',
            'The Review was deleted successfully' => 'Η αξιολόγηση διεφράφει με επιτυχία',
            'Users' => 'Χρήστες',
            'User Role' => 'Ρόλος Χρήστη',
            'Select a Role ...' => 'Διαλέξτε ένα ρόλο',
            'Administrator' => 'Διαχειρηστής',
            'User' => 'Χρήστης',
            'The user was updated successfully' => 'Ο χρήστης ενημερώθηκε με επιτυχία',
            'The user was deleted successfully' => 'Ο χρήστης διεφράφει με επιτυχία',
            'Create User' => 'Δημιουργία Χρήστη',
            'The user was created successfully' => 'Ο χρήστης προστέθηκε με επιτυχία',
            'Offers' => 'Προσφορές',
            'Only' => 'Μόνο',
            'No Results' => 'Χωρίς Αποτέλεσμα',
            'Search Results' => 'Αποτελέσματα Αναζήτησης',
            'Popular Products' => 'Δημοφιλη Προιοντα',
            'Add Review' => 'Προσθήκη αξιολόγησης',
            'Payment Information' => 'Πληροφορίες Πληρωμής',
            'Contact Information' => 'Πληροφορίες Επικοινωνίας',
            'Buyer Information' => 'Πληροφορίες Αγοραστή',
            'Per Status' => 'Ανα κατάσταση',
            'Per User' => 'Ανα χρήστη',
            'Gridview' => 'Πίνακας',
            'Statistics' => 'Στατιστικά',
        ];
    }
}