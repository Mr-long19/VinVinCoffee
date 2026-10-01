<?php
session_start();

// Adjust path to db.php if located in an includes folder, api folder, or root directory
if (file_exists('includes/db.php')) {
    require_once 'includes/db.php';
} elseif (file_exists('api/db.php')) {
    require_once 'api/db.php';
} else {
    require_once 'db.php';
}

// Handle Language Switch (KH / EN)
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'] === 'kh' ? 'kh' : 'en';
}
$lang = $_SESSION['lang'] ?? 'en';

// Translations Dictionary
$t = [
    'en' => [
        'title' => 'Roast & Craft - Admin Dashboard',
        'dashboard' => 'Dashboard Management',
        'logout' => 'Logout',
        'login_title' => 'Admin & Staff Login',
        'username' => 'Username',
        'email' => 'Email Address',
        'password' => 'Password',
        'login_btn' => 'Sign In',
        'reset_link' => 'Forgot Password? Reset Here',
        'reset_title' => 'Reset Password Request',
        'reset_pass_title' => 'Enter New Password',
        'new_password' => 'New Password',
        'request_reset_btn' => 'Send Reset Link',
        'reset_btn' => 'Update Password',
        'back_to_login' => 'Back to Login',
        'tab_menu' => 'Menu Items',
        'tab_ai' => 'AI Knowledge Base',
        'tab_users' => 'Users & Staff',
        'tab_settings' => 'Settings',
        'add_item' => 'Add Menu Item',
        'add_user' => 'Create New User / Staff',
        'add_ai_doc' => 'Add Knowledge Doc',
        'light' => 'Light Mode',
        'dark' => 'Dark Mode',
        'unauthorized' => 'Access Denied: You do not have permission to view this section.',
        'settings_header' => 'System & Store Configuration',
        'settings_sub' => 'Manage your coffee shop profile, operational preferences, dual-currency exchange rates, and AI assistant behavior.',
        'sec_general' => 'Store Profile & Identity',
        'sec_hours' => 'Operating Hours & Status',
        'sec_currency' => 'Currency & Pricing',
        'sec_ai' => 'AI Assistant Configuration',
        'sec_security' => 'Security & Access Control',
        'store_name' => 'Store Name',
        'store_email' => 'Contact Email',
        'store_phone' => 'Phone Number',
        'store_address' => 'Physical Address',
        'currency_rate' => 'Exchange Rate (1 USD to KHR)',
        'ai_prompt' => 'Custom AI System Prompt & Rules',
        'save_settings' => 'Save Configuration Changes',
        'settings_success' => 'Configuration updated successfully!'
    ],
    'kh' => [
        'title' => 'រ៉ូស & ក្ដាហ្វ - ទំព័រគ្រប់គ្រង',
        'dashboard' => 'ផ្ទាំងគ្រប់គ្រង',
        'logout' => 'ចាកចេញ',
        'login_title' => 'ចូលគណនីរដ្ឋបាល និងបុគ្គលិក',
        'username' => 'ឈ្មោះអ្នកប្រើប្រាស់',
        'email' => 'អ៊ីមែល',
        'password' => 'ពាក្យសម្ងាត់',
        'login_btn' => 'ចូលគណនី',
        'reset_link' => 'ភ្លេចពាក្យសម្ងាត់? កំណត់ឡើងវិញ',
        'reset_title' => 'ស្នើសុំកំណត់ពាក្យសម្ងាត់ឡើងវិញ',
        'reset_pass_title' => 'បញ្ចូលពាក្យសម្ងាត់ថ្មី',
        'new_password' => 'ពាក្យសម្ងាត់ថ្មី',
        'request_reset_btn' => 'ផ្ញើតំណភ្ជាប់កំណត់ឡើងវិញ',
        'reset_btn' => 'ប្តូរពាក្យសម្ងាត់',
        'back_to_login' => 'ត្រឡប់ទៅការចូល',
        'tab_menu' => 'មុខម្ហូប',
        'tab_ai' => 'មូលដ្ឋានទិន្នន័យ AI',
        'tab_users' => 'អ្នកប្រើប្រាស់ និងបុគ្គលិក',
        'tab_settings' => 'ការកំណត់ប្រព័ន្ធ',
        'add_item' => 'បន្ថែមមុខម្ហូបថ្មី',
        'add_user' => 'បង្កើតអ្នកប្រើប្រាស់ / បុគ្គលិកថ្មី',
        'add_ai_doc' => 'បន្ថែមឯកសារចំណេះដឹង',
        'light' => 'ពណ៌ភ្លឺ',
        'dark' => 'ពណ៌ងងឹត',
        'unauthorized' => 'ការចូលត្រូវបានបដិសេធ៖ អ្នកមិនមានសិទ្ធិមើលផ្នែកនេះទេ។',
        'settings_header' => 'ការកំណត់ប្រព័ន្ធ និងហាងកាហ្វេ',
        'settings_sub' => 'គ្រប់គ្រងព័ត៌មានហាង ម៉ោងបើក-បិទ អត្រាប្តូរប្រាក់ USD/KHR និងការកំណត់ជំនួយការ AI ។',
        'sec_general' => 'ព័ត៌មានលម្អិតហាង',
        'sec_hours' => 'ម៉ោងធ្វើការ និងស្ថានភាព',
        'sec_currency' => 'រូបិយប័ណ្ណ និងតម្លៃ',
        'sec_ai' => 'ការកំណត់ជំនួយការ AI',
        'sec_security' => 'សុវត្ថិភាព និងការគ្រប់គ្រងសិទ្ធិ',
        'store_name' => 'ឈ្មោះហាង',
        'store_email' => 'អ៊ីមែលទំនាក់ទំនង',
        'store_phone' => 'លេខទូរស័ព្ទ',
        'store_address' => 'អាសយដ្ឋានហាង',
        'currency_rate' => 'អត្រាប្តូរប្រាក់ (១ ដុល្លារ ជា រៀល)',
        'ai_prompt' => 'បទបញ្ជាប្រព័ន្ធ AI (System Prompt)',
        'save_settings' => 'រក្សាទុកការផ្លាស់ប្តូរ',
        'settings_success' => 'ការកំណត់ត្រូវបានរក្សាទុកដោយជោគជ័យ!'
    ]
];
$tr = $t[$lang];

// Handle Theme Mode Toggle
if (isset($_POST['toggle_theme'])) {
    $_SESSION['theme'] = (($_SESSION['theme'] ?? 'light') === 'dark') ? 'light' : 'dark';
    header("Location: admin.php?tab=" . ($_GET['tab'] ?? 'menu'));
    exit;
}
$current_theme = $_SESSION['theme'] ?? 'light';

// View Mode on Auth Page ('login', 'request_reset', 'process_reset')
$auth_view = $_GET['view'] ?? 'login';
if (isset($_GET['reset_token'])) {
    $auth_view = 'process_reset';
}

$login_error = '';
$reset_msg = '';

// Handle Login Action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM public.users WHERE username = ? OR email = ?");
        $stmt->execute([$user, $user]);
        $account = $stmt->fetch();

        if ($account) {
            $stored_pass = $account['password_hash'] ?? $account['password'] ?? '';
            if ($pass === $stored_pass || password_verify($pass, $stored_pass)) {
                $_SESSION['admin_logged'] = true;
                $_SESSION['username'] = $account['username'];
                $_SESSION['role'] = $account['role'] ?? 'admin';
                header("Location: admin.php");
                exit;
            }
        }
        $login_error = "Invalid username or password!";
    } catch (Exception $e) {
        $login_error = "Database Error: " . $e->getMessage();
    }
}

// Request Password Reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'forgot_password') {
    $email = trim($_POST['email']);
    
    try {
        $stmt = $pdo->prepare("SELECT id FROM public.users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user) {
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            $updateStmt = $pdo->prepare("UPDATE public.users SET reset_token = ?, reset_token_expires = ? WHERE id = ?");
            $updateStmt->execute([$token, $expires, $user['id']]);
            
            $reset_link = "admin.php?reset_token=" . $token;
            $reset_msg = "Reset token generated! <a href='{$reset_link}' class='underline font-bold text-caramel'>Click here to set new password</a>";
        } else {
            $login_error = "Email address not found!";
        }
    } catch (Exception $e) {
        $login_error = "Error processing request: " . $e->getMessage();
    }
}

// Process Password Reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'reset_password') {
    $token = $_POST['reset_token'];
    $new_password = $_POST['new_password'];
    
    try {
        $stmt = $pdo->prepare("SELECT id FROM public.users WHERE reset_token = ? AND reset_token_expires > NOW()");
        $stmt->execute([$token]);
        $user = $stmt->fetch();
        
        if ($user) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            $updateStmt = $pdo->prepare("UPDATE public.users SET password_hash = ?, reset_token = NULL, reset_token_expires = NULL WHERE id = ?");
            $updateStmt->execute([$hashed_password, $user['id']]);
            
            $reset_msg = "Password reset successful! You can now log in.";
            $auth_view = 'login';
        } else {
            $login_error = "Invalid or expired reset token!";
        }
    } catch (Exception $e) {
        $login_error = "Reset error: " . $e->getMessage();
    }
}

// Handle Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

$role = $_SESSION['role'] ?? 'staff';
$active_tab = $_GET['tab'] ?? 'menu';
if ($role === 'staff' && in_array($active_tab, ['users', 'ai'])) {
    $active_tab = 'menu';
}

// Handle User Creation (Admin only)
$user_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_user') {
    if (isset($_SESSION['admin_logged']) && $role === 'admin') {
        $new_user = trim($_POST['new_username']);
        $new_email = trim($_POST['new_email'] ?? '');
        $new_pass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $new_role = $_POST['new_role'];

        try {
            $stmt = $pdo->prepare("INSERT INTO public.users (username, email, password_hash, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$new_user, $new_email, $new_pass, $new_role]);
            $user_msg = "User/Staff created successfully!";
        } catch (Exception $e) {
            $user_msg = "Error: Username or email might already exist.";
        }
    }
}

// Handle AI Knowledge Base CRUD (Admin only)
$ai_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_ai_doc') {
    if (isset($_SESSION['admin_logged']) && $role === 'admin') {
        $title = trim($_POST['title']);
        $content = trim($_POST['content']);

        try {
            $stmt = $pdo->prepare("INSERT INTO ai_knowledge_docs (title, content) VALUES (?, ?)");
            $stmt->execute([$title, $content]);
            $ai_msg = "Knowledge document added successfully!";
        } catch (Exception $e) {
            $ai_msg = "Error adding document: " . $e->getMessage();
        }
    }
}

if (isset($_GET['delete_ai']) && $role === 'admin') {
    $doc_id = intval($_GET['delete_ai']);
    $stmt = $pdo->prepare("DELETE FROM ai_knowledge_docs WHERE id = ?");
    $stmt->execute([$doc_id]);
    header("Location: admin.php?tab=ai");
    exit;
}

// Handle Menu CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_menu') {
    if (isset($_SESSION['admin_logged'])) {
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $price_usd = $_POST['price_usd'];
        $price_khr = $_POST['price_khr'];
        $category = $_POST['category_slug'];
        $img = $_POST['image_url'];

        $stmt = $pdo->prepare("INSERT INTO menu_items (name, description, price_usd, price_khr, category_slug, image_url) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $desc, $price_usd, $price_khr, $category, $img]);
        header("Location: admin.php?tab=menu");
        exit;
    }
}

// Handle Settings Update
$settings_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_settings') {
    if (isset($_SESSION['admin_logged'])) {
        $settings_msg = $tr['settings_success'];
    }
}

// Fetch Data
$menu_items = [];
$ai_docs = [];
$users_list = [];
if (isset($_SESSION['admin_logged'])) {
    try {
        $menu_items = $pdo->query("SELECT * FROM menu_items ORDER BY id DESC")->fetchAll();
        if ($role === 'admin') {
            $ai_docs = $pdo->query("SELECT * FROM ai_knowledge_docs ORDER BY id DESC")->fetchAll();
            $users_list = $pdo->query("SELECT id, username, email, role, created_at FROM public.users ORDER BY id DESC")->fetchAll();
        }
    } catch (Exception $e) {}
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" class="<?= $current_theme === 'dark' ? 'dark bg-gray-900 text-white' : 'bg-cream text-espresso' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tr['title'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Kantumruy+Pro:wght@400;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', '"Kantumruy Pro"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif']
                    },
                    colors: {
                        espresso: '#1b1411',
                        caramel: '#8c5a3c',
                        latte: '#cda880',
                        foam: '#f7f4ef',
                        cream: '#faf8f5'
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen flex flex-col font-sans transition-colors duration-300">

    <?php if (!isset($_SESSION['admin_logged'])): ?>
    <!-- AUTH SCREEN (LOGIN / RESET) -->
    <div class="flex-1 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-xl max-w-md w-full border border-caramel/20">
            <div class="text-center mb-6">
                <div class="w-12 h-12 rounded-full bg-caramel/20 text-caramel flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-lock text-xl"></i>
                </div>
                <h2 class="font-serif text-2xl font-bold">
                    <?php 
                    if ($auth_view === 'request_reset') echo $tr['reset_title'];
                    elseif ($auth_view === 'process_reset') echo $tr['reset_pass_title'];
                    else echo $tr['login_title'];
                    ?>
                </h2>
                <div class="flex justify-center gap-4 mt-2 text-xs">
                    <a href="admin.php?lang=en&view=<?= $auth_view ?>" class="underline font-semibold <?= $lang==='en'?'text-caramel':'' ?>">English</a>
                    <a href="admin.php?lang=kh&view=<?= $auth_view ?>" class="underline font-semibold <?= $lang==='kh'?'text-caramel':'' ?>">ភាសាខ្មែរ</a>
                </div>
            </div>

            <?php if ($login_error): ?>
                <div class="mb-4 p-3 bg-red-100 text-red-700 text-xs rounded-xl font-medium"><?= $login_error ?></div>
            <?php endif; ?>
            <?php if ($reset_msg): ?>
                <div class="mb-4 p-3 bg-emerald-100 text-emerald-800 text-xs rounded-xl font-medium"><?= $reset_msg ?></div>
            <?php endif; ?>

            <?php if ($auth_view === 'login'): ?>
            <!-- Login Form -->
            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="login">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-1"><?= $tr['username'] ?></label>
                    <input type="text" name="username" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-700 border border-caramel/20 text-sm focus:outline-none focus:border-caramel">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-1"><?= $tr['password'] ?></label>
                    <input type="password" name="password" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-700 border border-caramel/20 text-sm focus:outline-none focus:border-caramel">
                </div>
                <button type="submit" class="w-full py-3.5 rounded-xl bg-caramel hover:bg-opacity-90 text-white font-bold text-sm transition-colors shadow-md">
                    <?= $tr['login_btn'] ?>
                </button>
                <div class="text-center pt-2">
                    <a href="admin.php?view=request_reset&lang=<?= $lang ?>" class="text-xs text-caramel hover:underline font-semibold"><?= $tr['reset_link'] ?></a>
                </div>
            </form>

            <?php elseif ($auth_view === 'request_reset'): ?>
            <!-- Request Reset Form -->
            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="forgot_password">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-1"><?= $tr['email'] ?></label>
                    <input type="email" name="email" required placeholder="admin@example.com" class="w-full px-4 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-700 border border-caramel/20 text-sm focus:outline-none focus:border-caramel">
                </div>
                <button type="submit" class="w-full py-3.5 rounded-xl bg-caramel hover:bg-opacity-90 text-white font-bold text-sm transition-colors shadow-md">
                    <?= $tr['request_reset_btn'] ?>
                </button>
                <div class="text-center pt-2">
                    <a href="admin.php?view=login&lang=<?= $lang ?>" class="text-xs text-caramel hover:underline font-semibold"><?= $tr['back_to_login'] ?></a>
                </div>
            </form>

            <?php elseif ($auth_view === 'process_reset'): ?>
            <!-- Process New Password Form -->
            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="reset_password">
                <input type="hidden" name="reset_token" value="<?= htmlspecialchars($_GET['reset_token'] ?? '') ?>">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-1"><?= $tr['new_password'] ?></label>
                    <input type="password" name="new_password" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-700 border border-caramel/20 text-sm focus:outline-none focus:border-caramel">
                </div>
                <button type="submit" class="w-full py-3.5 rounded-xl bg-caramel hover:bg-opacity-90 text-white font-bold text-sm transition-colors shadow-md">
                    <?= $tr['reset_btn'] ?>
                </button>
                <div class="text-center pt-2">
                    <a href="admin.php?view=login&lang=<?= $lang ?>" class="text-xs text-caramel hover:underline font-semibold"><?= $tr['back_to_login'] ?></a>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>

    <!-- ADMIN DASHBOARD -->
    <header class="bg-espresso text-foam px-6 py-4 flex items-center justify-between shadow-md">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-caramel/30 flex items-center justify-center text-latte">
                <i class="fa-solid fa-mug-hot text-lg"></i>
            </div>
            <div>
                <h1 class="font-serif font-bold text-lg"><?= $tr['dashboard'] ?></h1>
                <span class="text-xs text-latte">Welcome, <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?> (<?= htmlspecialchars($role) ?>)</span>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div class="flex gap-2 text-xs bg-espresso/50 px-3 py-1.5 rounded-xl border border-latte/20">
                <a href="admin.php?lang=en&tab=<?= $active_tab ?>" class="<?= $lang==='en'?'text-latte font-bold':'' ?>">EN</a> |
                <a href="admin.php?lang=kh&tab=<?= $active_tab ?>" class="<?= $lang==='kh'?'text-latte font-bold':'' ?>">KH</a>
            </div>
            <form method="POST">
                <button type="submit" name="toggle_theme" class="px-3 py-1.5 rounded-xl bg-latte/20 text-latte text-xs font-semibold hover:bg-latte/30 transition-colors">
                    <i class="fa-solid <?= $current_theme==='dark'?'fa-sun':'fa-moon' ?> mr-1"></i> <?= $current_theme==='dark'?$tr['light']:$tr['dark'] ?>
                </button>
            </form>
            <a href="admin.php?logout=1" class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-500 text-white text-xs font-bold transition-colors">
                <i class="fa-solid fa-right-from-bracket mr-1"></i> <?= $tr['logout'] ?>
            </a>
        </div>
    </header>

    <div class="flex-1 max-w-7xl w-full mx-auto p-6 grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Sidebar Tabs -->
        <div class="space-y-2">
            <a href="admin.php?tab=menu" class="block px-4 py-3 rounded-xl font-semibold text-sm transition-all <?= $active_tab==='menu'?'bg-caramel text-white shadow':'hover:bg-caramel/10' ?>">
                <i class="fa-solid fa-utensils mr-2"></i> <?= $tr['tab_menu'] ?>
            </a>
            <?php if ($role === 'admin'): ?>
            <a href="admin.php?tab=ai" class="block px-4 py-3 rounded-xl font-semibold text-sm transition-all <?= $active_tab==='ai'?'bg-caramel text-white shadow':'hover:bg-caramel/10' ?>">
                <i class="fa-solid fa-robot mr-2"></i> <?= $tr['tab_ai'] ?>
            </a>
            <a href="admin.php?tab=users" class="block px-4 py-3 rounded-xl font-semibold text-sm transition-all <?= $active_tab==='users'?'bg-caramel text-white shadow':'hover:bg-caramel/10' ?>">
                <i class="fa-solid fa-users mr-2"></i> <?= $tr['tab_users'] ?>
            </a>
            <?php endif; ?>
            <a href="admin.php?tab=settings" class="block px-4 py-3 rounded-xl font-semibold text-sm transition-all <?= $active_tab==='settings'?'bg-caramel text-white shadow':'hover:bg-caramel/10' ?>">
                <i class="fa-solid fa-gear mr-2"></i> <?= $tr['tab_settings'] ?>
            </a>
        </div>

        <!-- Content Panel -->
        <div class="md:col-span-3 bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-caramel/20">
            <?php if ($active_tab === 'menu'): ?>
                <h3 class="font-serif text-xl font-bold mb-4"><?= $tr['tab_menu'] ?></h3>
                <form method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-2xl">
                    <input type="hidden" name="action" value="save_menu">
                    <input type="text" name="name" placeholder="Item Name" required class="px-3 py-2 rounded-xl border text-xs dark:bg-gray-700 dark:border-gray-600">
                    <input type="text" name="category_slug" placeholder="Category (coffee, non-coffee, bakery)" required class="px-3 py-2 rounded-xl border text-xs dark:bg-gray-700 dark:border-gray-600">
                    <input type="number" step="0.01" name="price_usd" placeholder="Price USD ($)" required class="px-3 py-2 rounded-xl border text-xs dark:bg-gray-700 dark:border-gray-600">
                    <input type="text" name="price_khr" placeholder="Price KHR (e.g. 10,000 KHR)" required class="px-3 py-2 rounded-xl border text-xs dark:bg-gray-700 dark:border-gray-600">
                    <input type="text" name="image_url" placeholder="Image URL" class="sm:col-span-2 px-3 py-2 rounded-xl border text-xs dark:bg-gray-700 dark:border-gray-600">
                    <textarea name="description" placeholder="Description..." class="sm:col-span-2 px-3 py-2 rounded-xl border text-xs dark:bg-gray-700 dark:border-gray-600" rows="2"></textarea>
                    <button type="submit" class="sm:col-span-2 py-2.5 rounded-xl bg-caramel text-white font-bold text-xs"><?= $tr['add_item'] ?></button>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <tr class="border-b dark:border-gray-700 font-bold">
                            <th class="p-2">Name</th>
                            <th class="p-2">Category</th>
                            <th class="p-2">Price</th>
                        </tr>
                        <?php foreach($menu_items as $item): ?>
                        <tr class="border-b dark:border-gray-700/50">
                            <td class="p-2 font-semibold"><?= htmlspecialchars($item['name']) ?></td>
                            <td class="p-2"><?= htmlspecialchars($item['category_slug']) ?></td>
                            <td class="p-2">$<?= number_format($item['price_usd'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>

            <?php elseif ($active_tab === 'ai' && $role === 'admin'): ?>
                <h3 class="font-serif text-xl font-bold mb-4"><?= $tr['tab_ai'] ?></h3>
                <?php if ($ai_msg): ?>
                    <div class="mb-4 p-3 bg-emerald-100 text-emerald-800 text-xs rounded-xl font-medium"><?= $ai_msg ?></div>
                <?php endif; ?>
                
                <form method="POST" class="space-y-3 mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-2xl">
                    <input type="hidden" name="action" value="save_ai_doc">
                    <input type="text" name="title" placeholder="Document Title / Topic" required class="w-full px-3 py-2 rounded-xl border text-xs dark:bg-gray-700 dark:border-gray-600">
                    <textarea name="content" placeholder="Knowledge Content for AI..." required class="w-full px-3 py-2 rounded-xl border text-xs dark:bg-gray-700 dark:border-gray-600" rows="3"></textarea>
                    <button type="submit" class="py-2.5 px-4 rounded-xl bg-caramel text-white font-bold text-xs"><?= $tr['add_ai_doc'] ?></button>
                </form>

                <div class="space-y-3">
                    <?php foreach($ai_docs as $doc): ?>
                    <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-700/50 border border-caramel/10 flex justify-between items-start">
                        <div>
                            <h4 class="font-bold text-sm text-caramel"><?= htmlspecialchars($doc['title']) ?></h4>
                            <p class="text-xs mt-1 opacity-80"><?= htmlspecialchars($doc['content']) ?></p>
                        </div>
                        <a href="admin.php?tab=ai&delete_ai=<?= $doc['id'] ?>" onclick="return confirm('Are you sure you want to delete this document?');" class="text-red-500 hover:text-red-700 p-1">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>

            <?php elseif ($active_tab === 'users' && $role === 'admin'): ?>
                <h3 class="font-serif text-xl font-bold mb-4"><?= $tr['tab_users'] ?></h3>
                <?php if ($user_msg): ?>
                    <div class="mb-4 p-3 bg-emerald-100 text-emerald-800 text-xs rounded-xl font-medium"><?= $user_msg ?></div>
                <?php endif; ?>
                <form method="POST" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-2xl">
                    <input type="hidden" name="action" value="create_user">
                    <input type="text" name="new_username" placeholder="Username" required class="px-3 py-2 rounded-xl border text-xs dark:bg-gray-700 dark:border-gray-600">
                    <input type="email" name="new_email" placeholder="Email" class="px-3 py-2 rounded-xl border text-xs dark:bg-gray-700 dark:border-gray-600">
                    <input type="password" name="new_password" placeholder="Password" required class="px-3 py-2 rounded-xl border text-xs dark:bg-gray-700 dark:border-gray-600">
                    <select name="new_role" class="px-3 py-2 rounded-xl border text-xs dark:bg-gray-700 dark:border-gray-600">
                        <option value="staff">Staff</option>
                        <option value="admin">Admin</option>
                    </select>
                    <button type="submit" class="sm:col-span-2 md:col-span-4 py-2.5 rounded-xl bg-caramel text-white font-bold text-xs"><?= $tr['add_user'] ?></button>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <tr class="border-b dark:border-gray-700 font-bold">
                            <th class="p-2">Username</th>
                            <th class="p-2">Email</th>
                            <th class="p-2">Role</th>
                            <th class="p-2">Created At</th>
                        </tr>
                        <?php foreach($users_list as $u): ?>
                        <tr class="border-b dark:border-gray-700/50">
                            <td class="p-2 font-semibold"><?= htmlspecialchars($u['username']) ?></td>
                            <td class="p-2"><?= htmlspecialchars($u['email'] ?? '—') ?></td>
                            <td class="p-2 uppercase text-[10px] font-bold px-2 py-0.5 rounded bg-caramel/20 text-caramel inline-block"><?= htmlspecialchars($u['role']) ?></td>
                            <td class="p-2"><?= htmlspecialchars($u['created_at'] ?? 'N/A') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>

            <?php elseif ($active_tab === 'settings'): ?>
                <!-- SETTINGS TAB -->
                <div class="mb-6">
                    <h3 class="font-serif text-2xl font-bold flex items-center gap-2">
                        <i class="fa-solid fa-sliders text-caramel"></i> <?= $tr['settings_header'] ?>
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1"><?= $tr['settings_sub'] ?></p>
                </div>

                <?php if ($settings_msg): ?>
                    <div class="mb-6 p-4 bg-emerald-100 text-emerald-800 text-xs rounded-2xl font-medium flex items-center gap-2 shadow-sm">
                        <i class="fa-solid fa-circle-check text-base"></i> <?= $settings_msg ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-6">
                    <input type="hidden" name="action" value="save_settings">

                    <div class="p-5 rounded-2xl bg-gray-50 dark:bg-gray-700/40 border border-caramel/10 space-y-4">
                        <h4 class="font-bold text-sm text-caramel flex items-center gap-2">
                            <i class="fa-solid fa-store"></i> <?= $tr['sec_general'] ?>
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider mb-1 opacity-80"><?= $tr['store_name'] ?></label>
                                <input type="text" name="store_name" value="Roast & Craft Cafe" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-gray-800 border border-caramel/20 text-xs focus:outline-none focus:border-caramel font-medium">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider mb-1 opacity-80"><?= $tr['store_email'] ?></label>
                                <input type="email" name="store_email" value="contact@roastandcraft.com" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-gray-800 border border-caramel/20 text-xs focus:outline-none focus:border-caramel font-medium">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider mb-1 opacity-80"><?= $tr['store_phone'] ?></label>
                                <input type="text" name="store_phone" value="+855 12 345 678" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-gray-800 border border-caramel/20 text-xs focus:outline-none focus:border-caramel font-medium">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider mb-1 opacity-80"><?= $tr['store_address'] ?></label>
                                <input type="text" name="store_address" value="Phnom Penh, Cambodia" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-gray-800 border border-caramel/20 text-xs focus:outline-none focus:border-caramel font-medium">
                            </div>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl bg-gray-50 dark:bg-gray-700/40 border border-caramel/10 space-y-4">
                        <h4 class="font-bold text-sm text-caramel flex items-center gap-2">
                            <i class="fa-solid fa-coins"></i> <?= $tr['sec_currency'] ?>
                        </h4>
                        <div class="max-w-sm">
                            <label class="block text-[11px] font-bold uppercase tracking-wider mb-1 opacity-80"><?= $tr['currency_rate'] ?></label>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold px-3 py-2.5 bg-caramel/10 rounded-xl text-caramel">$1 =</span>
                                <input type="number" name="exchange_rate" value="4100" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-gray-800 border border-caramel/20 text-xs focus:outline-none focus:border-caramel font-medium">
                                <span class="text-xs font-bold px-3 py-2.5 bg-caramel/10 rounded-xl text-caramel">KHR</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl bg-gray-50 dark:bg-gray-700/40 border border-caramel/10 space-y-4">
                        <h4 class="font-bold text-sm text-caramel flex items-center gap-2">
                            <i class="fa-solid fa-wand-magic-sparkles"></i> <?= $tr['sec_ai'] ?>
                        </h4>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider mb-1 opacity-80"><?= $tr['ai_prompt'] ?></label>
                            <textarea name="ai_prompt" rows="3" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-gray-800 border border-caramel/20 text-xs focus:outline-none focus:border-caramel font-medium leading-relaxed">You are the friendly AI barista assistant for Roast & Craft. Help customers find beverages, recommend seasonal specials, and provide accurate pricing in USD and KHR.</textarea>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-xl bg-caramel hover:bg-opacity-90 text-white font-bold text-xs transition-all shadow-md flex items-center justify-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> <?= $tr['save_settings'] ?>
                    </button>
                </form>

            <?php else: ?>
                <div class="p-4 bg-red-100 text-red-700 text-xs rounded-xl font-medium"><?= $tr['unauthorized'] ?></div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

</body>
</html>
