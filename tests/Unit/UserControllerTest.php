<?php

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use App\Models\PaymentType;
use App\Models\Store;
use App\Models\User;
use App\Models\UserPaymentType;
use App\Services\StoreImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function test_new_user_saves_registration_session_and_redirects()
    {
        $request = Request::create('/register', 'POST', [
            'email' => 'newuser@example.test',
            'username' => 'newuser',
            'password' => 'secret123',
        ]);
        $request->setLaravelSession(session());

        $controller = new UserController();
        $response = $controller->newUser($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame('newuser@example.test', session('reg_email'));
        $this->assertSame('newuser', session('reg_username'));
    }

    public function test_save_profile_stores_profilepic_in_session()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.png');
        $request = Request::create('/new-profile', 'POST', [
            'nickname' => 'Newbie',
            'description' => 'Hello',
        ]);
        $request->files->set('profilepic', $file);
        $request->setLaravelSession(session());

        $controller = new UserController();
        $response = $controller->saveProfile($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertStringContainsString('temp_profile', session('reg_profilepic'));
        $this->assertSame('Newbie', session('reg_nickname'));
    }

    public function test_finalize_registration_creates_user_and_logs_in()
    {
        session([
            'reg_email' => 'finalize@example.test',
            'reg_username' => 'finalize',
            'reg_password' => Hash::make('secret123'),
            'reg_nickname' => 'Finalize',
            'reg_description' => 'Finalize desc',
            'reg_profilepic' => 'temp_profile/avatar.png',
            'reg_payment_type' => 1,
        ]);

        \App\Models\PaymentType::create(['paymentName' => 'Bank Transfer']);

        $request = Request::create('/finalize-registration', 'POST', [
            'payment_number' => '12345678',
        ]);
        $request->setLaravelSession(session());

        $service = new class extends StoreImageService {
            public function __construct()
            {
            }

            public function moveFromStoragePath(string $storagePath, string $folder, bool $returnBasename = false): string
            {
                return 'profile_pics/final_avatar.png';
            }
        };

        $controller = new UserController($service);
        $response = $controller->finalizeRegistration($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertDatabaseHas('users', ['email' => 'finalize@example.test']);
        $this->assertTrue(Auth::check());
        $this->assertNull(session('reg_email'));
        $this->assertNull(session('reg_username'));
    }

    public function test_login_redirects_with_valid_credentials()
    {
        $user = User::create([
            'email' => 'login@example.test',
            'username' => 'loginuser',
            'password' => Hash::make('secret123'),
        ]);

        $request = Request::create('/login', 'POST', [
            'username' => 'loginuser',
            'password' => 'secret123',
        ]);
        $request->setLaravelSession(session());

        $controller = new UserController();
        $response = $controller->login($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertTrue(Auth::check());
    }

    public function test_new_user_payment_stores_session_value()
    {
        $request = Request::create('/new-method', 'POST', [
            'payment_type' => 3,
        ]);
        $request->setLaravelSession(session());

        $controller = new UserController();
        $response = $controller->newUserPayment($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame(3, session('reg_payment_type'));
    }

    public function test_new_user_redirects_back_when_email_duplicate()
    {
        User::create([
            'email' => 'existing@example.test',
            'username' => 'existing',
            'password' => Hash::make('secret123'),
        ]);

        $request = Request::create('/register', 'POST', [
            'email' => 'existing@example.test',
            'username' => 'newuser',
            'password' => 'secret123',
        ]);
        $request->setLaravelSession(session());

        $controller = new UserController();
        $response = $controller->newUser($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame('Email already registered.', session('error'));
    }

    public function test_new_user_redirects_back_when_username_duplicate()
    {
        User::create([
            'email' => 'existing2@example.test',
            'username' => 'existing2',
            'password' => Hash::make('secret123'),
        ]);

        $request = Request::create('/register', 'POST', [
            'email' => 'new@example.test',
            'username' => 'existing2',
            'password' => 'secret123',
        ]);
        $request->setLaravelSession(session());

        $controller = new UserController();
        $response = $controller->newUser($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame('Username already taken.', session('error'));
    }

    public function test_save_profile_without_file_stores_session_data()
    {
        $request = Request::create('/new-profile', 'POST', [
            'nickname' => 'Newbie',
            'description' => 'Hello',
        ]);
        $request->setLaravelSession(session());

        $controller = new UserController();
        $response = $controller->saveProfile($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame('Newbie', session('reg_nickname'));
        $this->assertNull(session('reg_profilepic'));
    }

    public function test_login_redirects_back_with_invalid_credentials()
    {
        User::create([
            'email' => 'loginfail@example.test',
            'username' => 'loginfail',
            'password' => Hash::make('secret123'),
        ]);

        $request = Request::create('/login', 'POST', [
            'username' => 'loginfail',
            'password' => 'wrongpassword',
        ]);
        $request->setLaravelSession(session());

        $controller = new UserController();
        $response = $controller->login($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame('Username atau Password salah.', session('error'));
    }

    public function test_change_password_view_redirects_when_not_authenticated()
    {
        $controller = new UserController();
        $response = $controller->changePasswordView();

        $this->assertSame(302, $response->getStatusCode());
    }

    public function test_update_password_redirects_when_not_authenticated()
    {
        $request = Request::create('/profile/updatepassword', 'POST', [
            'oldPassword' => 'secret123',
            'newPassword' => 'newsecret',
            'confirmPassword' => 'newsecret',
        ]);
        $request->setLaravelSession(session());

        $controller = new UserController();
        $response = $controller->updatePassword($request);

        $this->assertSame(302, $response->getStatusCode());
    }

    public function test_payment_methods_view_redirects_when_not_authenticated()
    {
        $controller = new UserController();
        $response = $controller->paymentMethodsView();

        $this->assertSame(302, $response->getStatusCode());
    }

    public function test_add_new_payment_view_redirects_when_not_authenticated()
    {
        $controller = new UserController();
        $response = $controller->addNewPaymentView();

        $this->assertSame(302, $response->getStatusCode());
    }

    public function test_store_payment_method_redirects_when_not_authenticated()
    {
        $request = Request::create('/profile/paymentmethods/store', 'POST', [
            'idPaymentType' => 1,
            'paymentDetails' => '987654321',
        ]);
        $request->setLaravelSession(session());

        $controller = new UserController();
        $response = $controller->storePaymentMethod($request);

        $this->assertSame(302, $response->getStatusCode());
    }

    public function test_manageprofile_returns_view_for_authenticated_user()
    {
        $user = User::create([
            'email' => 'manageprofile@example.test',
            'username' => 'manageprofile',
            'password' => Hash::make('secret123'),
        ]);

        Auth::login($user);

        $controller = new UserController();
        $response = $controller->manageprofile();

        $this->assertSame('manageprofile.profilepageview', $response->getName());
        $this->assertArrayHasKey('user', $response->getData());
    }

    public function test_edit_profile_returns_view_for_authenticated_user()
    {
        $user = User::create([
            'email' => 'editprofile@example.test',
            'username' => 'editprofile',
            'password' => Hash::make('secret123'),
        ]);

        Auth::login($user);

        $controller = new UserController();
        $response = $controller->editProfile();

        $this->assertSame('manageprofile.editprofileview', $response->getName());
        $this->assertArrayHasKey('user', $response->getData());
    }

    public function test_update_profile_saves_new_profile_pic_and_fields()
    {
        Storage::fake('public');

        $user = User::create([
            'email' => 'updateprofile@example.test',
            'username' => 'updateprofile',
            'password' => Hash::make('secret123'),
        ]);

        Auth::login($user);

        $file = UploadedFile::fake()->image('avatar.png');
        $request = Request::create('/profile/update', 'POST', [
            'nickname' => 'Updated Nick',
            'description' => 'Updated desc',
        ]);
        $request->files->set('profilepic', $file);
        $request->setLaravelSession(session());

        $service = new class extends StoreImageService {
            public function __construct()
            {
            }

            public function saveImageToFolder(UploadedFile $file, string $folder): string
            {
                return 'updated_profile.png';
            }
        };

        $controller = new UserController($service);
        $response = $controller->updateProfile($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertDatabaseHas('users', [
            'username' => 'updateprofile',
            'nickname' => 'Updated Nick',
            'description' => 'Updated desc',
            'profilepic' => 'profile_pics/updated_profile.png',
        ]);
    }

    public function test_update_password_with_correct_old_password_updates_password()
    {
        $user = User::create([
            'email' => 'updatepass@example.test',
            'username' => 'updatepass',
            'password' => Hash::make('secret123'),
        ]);

        Auth::login($user);

        $request = Request::create('/profile/updatepassword', 'POST', [
            'oldPassword' => 'secret123',
            'newPassword' => 'newsecret',
            'confirmPassword' => 'newsecret',
        ]);
        $request->setLaravelSession(session());

        $controller = new UserController();
        $response = $controller->updatePassword($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertTrue(Hash::check('newsecret', $user->fresh()->password));
    }

    public function test_update_password_with_incorrect_old_password_redirects_back()
    {
        $user = User::create([
            'email' => 'badoldpass@example.test',
            'username' => 'badoldpass',
            'password' => Hash::make('secret123'),
        ]);

        Auth::login($user);

        $request = Request::create('/profile/updatepassword', 'POST', [
            'oldPassword' => 'wrong123',
            'newPassword' => 'newsecret',
            'confirmPassword' => 'newsecret',
        ]);
        $request->setLaravelSession(session());

        $controller = new UserController();
        $response = $controller->updatePassword($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertTrue(Hash::check('secret123', $user->fresh()->password));
    }

    public function test_payment_methods_view_returns_view_for_authenticated_user()
    {
        $user = User::create([
            'email' => 'paymentsview@example.test',
            'username' => 'paymentsview',
            'password' => Hash::make('secret123'),
        ]);

        $paymentType = PaymentType::create(['paymentName' => 'Bank Transfer']);
        UserPaymentType::create([
            'idUser' => $user->idUser,
            'idPaymentType' => $paymentType->idPaymentType,
            'paymentDetails' => '12345678',
        ]);

        Auth::login($user);

        $controller = new UserController();
        $response = $controller->paymentMethodsView();

        $this->assertSame('manageprofile.paymentmethodsmenuview', $response->getName());
        $this->assertArrayHasKey('paymentMethods', $response->getData());
    }

    public function test_set_default_payment_method_updates_user_payment_types()
    {
        $user = User::create([
            'email' => 'defaultpm@example.test',
            'username' => 'defaultpm',
            'password' => Hash::make('secret123'),
        ]);

        $paymentType = PaymentType::create(['paymentName' => 'Bank Transfer']);
        $firstUpt = UserPaymentType::create([
            'idUser' => $user->idUser,
            'idPaymentType' => $paymentType->idPaymentType,
            'paymentDetails' => '123',
            'is_default' => 1,
        ]);
        $secondUpt = UserPaymentType::create([
            'idUser' => $user->idUser,
            'idPaymentType' => $paymentType->idPaymentType,
            'paymentDetails' => '456',
            'is_default' => 0,
        ]);

        Auth::login($user);

        $request = Request::create('/profile/paymentmethods/default', 'POST', [
            'idUserPaymentType' => $secondUpt->idUserPaymentType,
        ]);
        $request->setLaravelSession(session());

        $controller = new UserController();
        $response = $controller->setDefaultPaymentMethod($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertEquals(0, $firstUpt->fresh()->is_default);
        $this->assertEquals(1, $secondUpt->fresh()->is_default);
    }

    public function test_add_new_payment_view_returns_view()
    {
        $user = User::create([
            'email' => 'newpayview@example.test',
            'username' => 'newpayview',
            'password' => Hash::make('secret123'),
        ]);

        Auth::login($user);

        $controller = new UserController();
        $response = $controller->addNewPaymentView();

        $this->assertSame('manageprofile.newpaymentmethod', $response->getName());
    }

    public function test_store_payment_method_creates_user_payment_type()
    {
        $user = User::create([
            'email' => 'storepaymethod@example.test',
            'username' => 'storepaymethod',
            'password' => Hash::make('secret123'),
        ]);

        $paymentType = PaymentType::create(['paymentName' => 'Bank Transfer']);

        Auth::login($user);

        $request = Request::create('/profile/paymentmethods/store', 'POST', [
            'idPaymentType' => $paymentType->idPaymentType,
            'paymentDetails' => '987654321',
        ]);
        $request->setLaravelSession(session());

        $controller = new UserController();
        $response = $controller->storePaymentMethod($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertDatabaseHas('user_payment_types', [
            'idUser' => $user->idUser,
            'idPaymentType' => $paymentType->idPaymentType,
            'paymentDetails' => '987654321',
        ]);
    }

    public function test_change_password_view_returns_view_when_authenticated()
    {
        $user = User::create([
            'email' => 'changepass@example.test',
            'username' => 'changepass',
            'password' => Hash::make('secret123'),
        ]);

        Auth::login($user);

        $controller = new UserController();
        $response = $controller->changePasswordView();

        $this->assertSame('manageprofile.changepasswordview', $response->getName());
    }

    public function test_logout_redirects_and_invalidates_session()
    {
        $user = User::create([
            'email' => 'logout@example.test',
            'username' => 'logoutuser',
            'password' => Hash::make('secret123'),
        ]);

        Auth::login($user);

        $request = Request::create('/logout', 'POST');
        $request->setLaravelSession(session());

        $controller = new UserController();
        $response = $controller->logout($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertFalse(Auth::check());
    }
}
