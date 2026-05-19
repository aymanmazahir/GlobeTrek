<?php
// seed.php - sample data seeder for GlobeTrek Adventures
require_once __DIR__ . '/../includes/db.php';

echo "Starting database seeding...\n";

try {
    // 1. Clean existing sample data (except original admin/staff if possible)
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    $pdo->exec("TRUNCATE TABLE payments;");
    $pdo->exec("TRUNCATE TABLE bookings;");
    $pdo->exec("TRUNCATE TABLE inquiries;");
    $pdo->exec("TRUNCATE TABLE packages;");
    
    // Clear only customers and users who are not admin or original staff
    $pdo->exec("DELETE FROM customers;");
    $pdo->exec("DELETE FROM users WHERE id > 2;");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

    // 2. Insert Premium Sri Lankan Packages
    $packages = [
        [
            'title' => 'Sigiriya Sky Fortress Heritage Trek',
            'destination' => 'Sigiriya',
            'summary' => 'Explore the ancient Sigiriya Lion Rock Fortress, a UNESCO World Heritage site rising 200m above the jungle. Package includes a guided climb, visits to local pottery villages, and traditional buffet dining.',
            'price' => 850.00,
            'duration_days' => 3,
            'image_url' => 'default_package.jpg',
            'status' => 'active'
        ],
        [
            'title' => 'Ella Misty Tea Valley Trails & Pekoe Walking',
            'destination' => 'Ella',
            'summary' => 'Embark on a scenic journey through the misty tea gardens of Ella. Walk the famous Pekoe Trail Stage 6, photograph the historic Nine Arch Bridge, and participate in village cooking classes.',
            'price' => 650.00,
            'duration_days' => 4,
            'image_url' => 'default_package.jpg',
            'status' => 'active'
        ],
        [
            'title' => 'Mirissa Whale Safari & Surf Break',
            'destination' => 'Mirissa',
            'summary' => 'Witness majestic Blue Whales swimming in their natural habitat under strict eco-friendly protocols, then catch clean swells at Weligama Beach with dedicated local surf coaches.',
            'price' => 920.00,
            'duration_days' => 5,
            'image_url' => 'default_package.jpg',
            'status' => 'active'
        ],
        [
            'title' => 'Yala Wilderness Expedition & Glamping',
            'destination' => 'Yala',
            'summary' => 'A high-fidelity luxury wildlife experience. Enjoy guided open-top jeep safaris in Yala National Park to spot wild leopards, elephants, and rare bird species, followed by luxury shoreline glamping.',
            'price' => 1150.00,
            'duration_days' => 4,
            'image_url' => 'default_package.jpg',
            'status' => 'active'
        ],
        [
            'title' => 'Galle Dutch Fort Coastal Heritage Walk',
            'destination' => 'Galle Fort',
            'summary' => 'Step back in time inside the pristine, historic Galle Fort. Walk colonial-era cobblestones, photograph the iconic lighthouse, and enjoy premium seafood dining overlooking the Indian Ocean.',
            'price' => 450.00,
            'duration_days' => 2,
            'image_url' => 'default_package.jpg',
            'status' => 'active'
        ],
        [
            'title' => 'Trincomalee Shipwreck Diving & Reef Snorkeling',
            'destination' => 'Trincomalee',
            'summary' => 'Dive historic naval shipwrecks and explore beautiful coral gardens at Pigeon Island, guided by PADI-certified professionals. Spot blacktip reef sharks and sea turtles.',
            'price' => 890.00,
            'duration_days' => 4,
            'image_url' => 'default_package.jpg',
            'status' => 'active'
        ]
    ];

    $insPkg = $pdo->prepare("
        INSERT INTO packages (title, destination, summary, price, duration_days, image_url, status) 
        VALUES (:title, :destination, :summary, :price, :duration_days, :image_url, :status)
    ");
    
    $packageIds = [];
    foreach ($packages as $pkg) {
        $insPkg->execute($pkg);
        $packageIds[] = $pdo->lastInsertId();
    }
    echo "Inserted " . count($packageIds) . " travel packages successfully.\n";

    // 3. Insert Premium Customers
    $customers = [
        [
            'email' => 'priya.k@yahoo.com',
            'full_name' => 'Priya Karunanayake',
            'phone' => '+94 77 987 6543',
            'address' => '12 Rose Gardens, Colombo 03, Sri Lanka'
        ],
        [
            'email' => 'sohan.m@gmail.com',
            'full_name' => 'Sohan Mendis',
            'phone' => '+94 71 234 5678',
            'address' => '45 Temple Road, Kandy, Sri Lanka'
        ],
        [
            'email' => 'mala.r@outlook.com',
            'full_name' => 'Mala Rajapakse',
            'phone' => '+94 72 888 1122',
            'address' => '88 Beachside Ave, Negombo, Sri Lanka'
        ],
        [
            'email' => 'sarah.j@gmail.com',
            'full_name' => 'Sarah Jenkins',
            'phone' => '+1 415 555 0192',
            'address' => 'Market St, San Francisco, USA'
        ],
        [
            'email' => 'david.m@yahoo.com',
            'full_name' => 'David Miller',
            'phone' => '+44 20 7946 0958',
            'address' => 'Kings Road, London, UK'
        ]
    ];

    $insUser = $pdo->prepare("INSERT INTO users (email, password_hash, role, created_at) VALUES (?, ?, 'customer', ?)");
    $insCust = $pdo->prepare("INSERT INTO customers (user_id, full_name, phone, address) VALUES (?, ?, ?, ?)");

    $customerIds = [];
    // Spread user registration dates across different months to make user metrics look realistic
    $createdDates = [
        '2026-01-10 14:00:00',
        '2026-02-15 09:30:00',
        '2026-03-20 11:20:00',
        '2026-04-05 16:45:00',
        '2026-05-18 10:15:00'
    ];

    foreach ($customers as $i => $cust) {
        $hash = password_hash('Customer@123', PASSWORD_BCRYPT);
        $insUser->execute([$cust['email'], $hash, $createdDates[$i]]);
        $userId = $pdo->lastInsertId();

        $insCust->execute([$userId, $cust['full_name'], $cust['phone'], $cust['address']]);
        $customerIds[] = $pdo->lastInsertId();
    }
    echo "Inserted " . count($customerIds) . " users and customer profiles successfully.\n";

    // 4. Insert Bookings Spread Across Months
    // Months: Jan, Feb, Mar, Apr, May (approved ones populate the Monthly Revenue chart!)
    $bookings = [
        [
            'customer_id' => $customerIds[0], // Priya
            'package_id' => $packageIds[0],  // Sigiriya ($850)
            'travel_date' => '2026-02-10',
            'guests_count' => 2,
            'status' => 'approved',
            'total_price' => 1700.00,
            'created_at' => '2026-01-15 10:00:00'
        ],
        [
            'customer_id' => $customerIds[1], // Sohan
            'package_id' => $packageIds[1],  // Ella ($650)
            'travel_date' => '2026-03-15',
            'guests_count' => 3,
            'status' => 'approved',
            'total_price' => 1950.00,
            'created_at' => '2026-02-18 14:30:00'
        ],
        [
            'customer_id' => $customerIds[2], // Mala
            'package_id' => $packageIds[2],  // Mirissa ($920)
            'travel_date' => '2026-04-20',
            'guests_count' => 2,
            'status' => 'approved',
            'total_price' => 1840.00,
            'created_at' => '2026-03-25 11:15:00'
        ],
        [
            'customer_id' => $customerIds[3], // Sarah
            'package_id' => $packageIds[3],  // Yala ($1150)
            'travel_date' => '2026-05-25',
            'guests_count' => 2,
            'status' => 'approved',
            'total_price' => 2300.00,
            'created_at' => '2026-04-10 16:00:00'
        ],
        [
            'customer_id' => $customerIds[4], // David
            'package_id' => $packageIds[4],  // Galle ($450)
            'travel_date' => '2026-06-05',
            'guests_count' => 4,
            'status' => 'pending',
            'total_price' => 1800.00,
            'created_at' => '2026-05-18 13:00:00'
        ],
        [
            'customer_id' => $customerIds[0], // Priya
            'package_id' => $packageIds[5],  // Trinco ($890)
            'travel_date' => '2026-07-01',
            'guests_count' => 1,
            'status' => 'cancelled',
            'total_price' => 890.00,
            'created_at' => '2026-05-19 02:30:00'
        ]
    ];

    $insBk = $pdo->prepare("
        INSERT INTO bookings (customer_id, package_id, travel_date, guests_count, status, total_price, created_at) 
        VALUES (:customer_id, :package_id, :travel_date, :guests_count, :status, :total_price, :created_at)
    ");
    
    $bookingIds = [];
    foreach ($bookings as $bk) {
        $insBk->execute($bk);
        $bookingIds[] = $pdo->lastInsertId();
    }
    echo "Inserted " . count($bookingIds) . " bookings successfully.\n";

    // 5. Insert Simulated Payments
    $payments = [
        [
            'booking_id' => $bookingIds[0],
            'amount' => 1700.00,
            'payment_method' => 'Visa Card',
            'status' => 'completed',
            'transaction_date' => '2026-01-15 10:05:00'
        ],
        [
            'booking_id' => $bookingIds[1],
            'amount' => 1950.00,
            'payment_method' => 'Mastercard',
            'status' => 'completed',
            'transaction_date' => '2026-02-18 14:32:00'
        ],
        [
            'booking_id' => $bookingIds[2],
            'amount' => 1840.00,
            'payment_method' => 'American Express',
            'status' => 'completed',
            'transaction_date' => '2026-03-25 11:18:00'
        ],
        [
            'booking_id' => $bookingIds[3],
            'amount' => 2300.00,
            'payment_method' => 'Visa Card',
            'status' => 'completed',
            'transaction_date' => '2026-04-10 16:03:00'
        ]
    ];

    $insPay = $pdo->prepare("
        INSERT INTO payments (booking_id, amount, payment_method, status, transaction_date) 
        VALUES (:booking_id, :amount, :payment_method, :status, :transaction_date)
    ");
    foreach ($payments as $pay) {
        $insPay->execute($pay);
    }
    echo "Inserted payments successfully.\n";

    // 6. Insert Inquiries
    $inquiries = [
        [
            'name' => 'John Sterling',
            'email' => 'john.s@gmail.com',
            'subject' => 'Corporate Package Options',
            'message' => 'Hello, I represent a company planning a retreat for 15 employees. Can we customize the Yala Expedition to include team building activities?',
            'status' => 'unread'
        ],
        [
            'name' => 'Aiko Tanaka',
            'email' => 'aiko@japan-travels.jp',
            'subject' => 'Airport Transfers',
            'message' => 'Does the Sigiriya Sky Fortress Heritage package include pickup from Bandaranaike International Airport upon arrival?',
            'status' => 'read'
        ],
        [
            'name' => 'Liam Evans',
            'email' => 'liam.e@yahoo.co.uk',
            'subject' => 'Dietary Requirements',
            'message' => 'We are interested in booking the Ella Misty Tea Valley tour. Are vegan and gluten-free meal options available for the village cooking class?',
            'status' => 'replied'
        ]
    ];

    $insInq = $pdo->prepare("
        INSERT INTO inquiries (name, email, subject, message, status) 
        VALUES (:name, :email, :subject, :message, :status)
    ");
    foreach ($inquiries as $inq) {
        $insInq->execute($inq);
    }
    echo "Inserted inquiries successfully.\n";

    echo "Database seeding finished successfully!\n";

} catch (Exception $e) {
    echo "ERROR DURING SEEDING: " . $e->getMessage() . "\n";
}
