<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\IbuHamil;
use App\Models\Balita;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NikValidationTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Dynamically add missing columns to sqlite tables if they don't exist
        if (\DB::connection()->getDriverName() === 'sqlite') {
            if (!\Schema::hasColumn('ibu_hamil', 'created_by')) {
                \Schema::table('ibu_hamil', function ($table) {
                    $table->unsignedBigInteger('created_by')->nullable();
                    $table->unsignedBigInteger('updated_by')->nullable();
                });
            }
            if (!\Schema::hasColumn('balita', 'nama_ibu')) {
                \Schema::table('balita', function ($table) {
                    $table->string('nama_ibu')->nullable();
                    $table->string('nik_ibu')->nullable();
                    $table->text('alamat')->nullable();
                    $table->unsignedBigInteger('created_by')->nullable();
                    $table->unsignedBigInteger('updated_by')->nullable();
                });
            }
        }

        // Create a user with role ketua or kader to bypass RoleMiddleware
        $this->user = User::create([
            'nama' => 'Test Admin',
            'email' => 'test-admin-' . uniqid() . '@example.com',
            'password' => bcrypt('password'),
            'role' => 'ketua',
        ]);
    }

    /**
     * Test Ibu Hamil NIK validation rules on store.
     */
    public function test_ibu_hamil_store_nik_validation()
    {
        $this->actingAs($this->user);

        // Case: Valid mother NIK
        $nikMother1 = '1234567890123456';
        $response = $this->post(route('ibu-hamil.store'), [
            'nama_ibu' => 'Siti Aminah',
            'nik' => $nikMother1,
            'tanggal_lahir' => '1990-05-15',
            'alamat' => 'Jl. Kenanga No. 5',
            'no_hp' => '081299998888',
            'gravida' => 2,
            'partus' => 1,
            'abortus' => 0,
            'hpht' => '2026-01-01',
        ]);
        $response->assertRedirect(route('ibu-hamil.index'));
        $this->assertDatabaseHas('ibu_hamil', ['nik' => $nikMother1]);

        // Case: Duplicate Mother NIK in ibu_hamil
        $response = $this->post(route('ibu-hamil.store'), [
            'nama_ibu' => 'Siti Fatima',
            'nik' => $nikMother1, // duplicate NIK
            'tanggal_lahir' => '1992-07-20',
            'alamat' => 'Jl. Mawar No. 12',
            'no_hp' => '081277776666',
            'gravida' => 1,
            'partus' => 0,
            'abortus' => 0,
            'hpht' => '2026-02-01',
        ]);
        $response->assertSessionHasErrors(['nik']);
        $errors = session('errors')->get('nik');
        $this->assertEquals('NIK sudah terdaftar atau digunakan.', $errors[0]);

        // Case: Duplicate NIK used as child NIK
        $nikChild = '9876543210987654';
        Balita::create([
            'nama_balita' => 'Budi',
            'nik' => $nikChild,
            'tanggal_lahir' => '2025-01-01',
            'jenis_kelamin' => 'L',
            'nama_ibu' => 'Indah',
            'nik_ibu' => '1111222233334444',
            'no_hp_ortu' => '0812',
            'alamat' => 'Jl. Indah',
            'created_by' => $this->user->id,
        ]);

        $response = $this->post(route('ibu-hamil.store'), [
            'nama_ibu' => 'Rini',
            'nik' => $nikChild, // duplicate child NIK
            'tanggal_lahir' => '1995-10-10',
            'alamat' => 'Jl. Bunga',
            'no_hp' => '081255554444',
            'gravida' => 1,
            'partus' => 0,
            'abortus' => 0,
            'hpht' => '2026-03-01',
        ]);
        $response->assertSessionHasErrors(['nik']);
        $errors = session('errors')->get('nik');
        $this->assertEquals('NIK sudah terdaftar atau digunakan.', $errors[0]);
    }

    /**
     * Test Ibu Hamil NIK validation rules on update.
     */
    public function test_ibu_hamil_update_nik_validation()
    {
        $this->actingAs($this->user);

        // Create Mother 1
        $mother1 = IbuHamil::create([
            'nama_ibu' => 'Siti Aminah',
            'nik' => '1234567890123456',
            'tanggal_lahir' => '1990-05-15',
            'alamat' => 'Jl. Kenanga No. 5',
            'no_hp' => '081299998888',
            'gravida' => 2,
            'partus' => 1,
            'abortus' => 0,
            'hpht' => '2026-01-01',
            'created_by' => $this->user->id,
        ]);

        // Create Mother 2
        $mother2 = IbuHamil::create([
            'nama_ibu' => 'Siti Fatima',
            'nik' => '2234567890123456',
            'tanggal_lahir' => '1992-07-20',
            'alamat' => 'Jl. Mawar',
            'no_hp' => '081277776666',
            'gravida' => 1,
            'partus' => 0,
            'abortus' => 0,
            'hpht' => '2026-02-01',
            'created_by' => $this->user->id,
        ]);

        // Case 1 (VALID): Edit Mother 1, keeping her NIK. Should not fail!
        $response = $this->put(route('ibu-hamil.update', $mother1->id), [
            'nama_ibu' => 'Siti Aminah Updated',
            'nik' => '1234567890123456', // same NIK
            'tanggal_lahir' => '1990-05-15',
            'alamat' => 'Jl. Kenanga No. 5',
            'no_hp' => '081299998888',
            'gravida' => 2,
            'partus' => 1,
            'abortus' => 0,
            'hpht' => '2026-01-01',
        ]);
        $response->assertRedirect(route('ibu-hamil.index'));
        $this->assertDatabaseHas('ibu_hamil', [
            'id' => $mother1->id,
            'nama_ibu' => 'Siti Aminah Updated',
        ]);

        // Case: Edit Mother 1, changing to Mother 2's NIK. Should fail!
        $response = $this->put(route('ibu-hamil.update', $mother1->id), [
            'nama_ibu' => 'Siti Aminah Updated Again',
            'nik' => '2234567890123456', // Mother 2's NIK
            'tanggal_lahir' => '1990-05-15',
            'alamat' => 'Jl. Kenanga No. 5',
            'no_hp' => '081299998888',
            'gravida' => 2,
            'partus' => 1,
            'abortus' => 0,
            'hpht' => '2026-01-01',
        ]);
        $response->assertSessionHasErrors(['nik']);
        $errors = session('errors')->get('nik');
        $this->assertEquals('NIK sudah terdaftar atau digunakan.', $errors[0]);

        // Case: Edit Mother 1 with NIK already linked to a child that belongs to her (VALID).
        // Let's create a child for Mother 1.
        $child = Balita::create([
            'ibu_hamil_id' => $mother1->id,
            'nama_balita' => 'Budi',
            'nik' => '9876543210987654',
            'tanggal_lahir' => '2025-01-01',
            'jenis_kelamin' => 'L',
            'nama_ibu' => $mother1->nama_ibu,
            'nik_ibu' => $mother1->nik, // '1234567890123456'
            'no_hp_ortu' => '0812',
            'alamat' => 'Jl. Indah',
            'created_by' => $this->user->id,
        ]);

        // Edit Mother 1, keeping her NIK. It matches the child's nik_ibu, but since it's a valid relation, it should succeed!
        $response = $this->put(route('ibu-hamil.update', $mother1->id), [
            'nama_ibu' => 'Siti Aminah Relasi Sah',
            'nik' => '1234567890123456',
            'tanggal_lahir' => '1990-05-15',
            'alamat' => 'Jl. Kenanga No. 5',
            'no_hp' => '081299998888',
            'gravida' => 2,
            'partus' => 1,
            'abortus' => 0,
            'hpht' => '2026-01-01',
        ]);
        $response->assertRedirect(route('ibu-hamil.index'));
        $this->assertDatabaseHas('ibu_hamil', [
            'id' => $mother1->id,
            'nama_ibu' => 'Siti Aminah Relasi Sah',
        ]);

        // Edit Mother 1, changing to a NIK that is used by a child as nik_ibu of ANOTHER mother. Should fail!
        // First create another child with a different mother and unique nik_ibu.
        Balita::create([
            'ibu_hamil_id' => $mother2->id,
            'nama_balita' => 'Andi',
            'nik' => '9876543210987655',
            'tanggal_lahir' => '2025-01-01',
            'jenis_kelamin' => 'L',
            'nama_ibu' => $mother2->nama_ibu,
            'nik_ibu' => '5555555555555555',
            'no_hp_ortu' => '0812',
            'alamat' => 'Jl. Indah 2',
            'created_by' => $this->user->id,
        ]);

        // Trying to edit mother 1 and changing her NIK to '5555555555555555'. Should fail because it is used by another child.
        $response = $this->put(route('ibu-hamil.update', $mother1->id), [
            'nama_ibu' => 'Siti Aminah Relasi Salah',
            'nik' => '5555555555555555',
            'tanggal_lahir' => '1990-05-15',
            'alamat' => 'Jl. Kenanga No. 5',
            'no_hp' => '081299998888',
            'gravida' => 2,
            'partus' => 1,
            'abortus' => 0,
            'hpht' => '2026-01-01',
        ]);
        $response->assertSessionHasErrors(['nik']);
        $errors = session('errors')->get('nik');
        $this->assertEquals('NIK sudah terdaftar atau digunakan.', $errors[0]);
    }

    /**
     * Test Balita store validation rules.
     */
    public function test_balita_store_validation()
    {
        $this->actingAs($this->user);

        // Create Mother
        $mother = IbuHamil::create([
            'nama_ibu' => 'Siti Aminah',
            'nik' => '1234567890123456',
            'tanggal_lahir' => '1990-05-15',
            'alamat' => 'Jl. Kenanga No. 5',
            'no_hp' => '081299998888',
            'gravida' => 2,
            'partus' => 1,
            'abortus' => 0,
            'hpht' => '2026-01-01',
            'created_by' => $this->user->id,
        ]);

        // Case 2 (VALID): Create balita choosing mother from dropdown
        $response = $this->post(route('balita.store'), [
            'ibu_hamil_id' => $mother->id,
            'nama_balita' => 'Budi',
            'nik' => '1111111111111111',
            'tanggal_lahir' => '2025-01-01',
            'jenis_kelamin' => 'L',
            'nama_ibu' => $mother->nama_ibu,
            'nik_ibu' => $mother->nik, // automic mother NIK
            'no_hp' => $mother->no_hp,
            'alamat' => $mother->alamat,
        ]);
        $response->assertRedirect(route('balita.index'));
        $this->assertDatabaseHas('balita', [
            'nama_balita' => 'Budi',
            'ibu_hamil_id' => $mother->id,
            'nik_ibu' => $mother->nik,
        ]);

        // Create another balita for the same mother (VALID sibling relation)
        $response = $this->post(route('balita.store'), [
            'ibu_hamil_id' => $mother->id,
            'nama_balita' => 'Wati',
            'nik' => '2222222222222222',
            'tanggal_lahir' => '2025-05-01',
            'jenis_kelamin' => 'P',
            'nama_ibu' => $mother->nama_ibu,
            'nik_ibu' => $mother->nik, // automic mother NIK
            'no_hp' => $mother->no_hp,
            'alamat' => $mother->alamat,
        ]);
        $response->assertRedirect(route('balita.index'));
        $this->assertDatabaseHas('balita', [
            'nama_balita' => 'Wati',
            'ibu_hamil_id' => $mother->id,
            'nik_ibu' => $mother->nik,
        ]);

        // Case: Create balita with child NIK that is already used. Should fail!
        $response = $this->post(route('balita.store'), [
            'ibu_hamil_id' => $mother->id,
            'nama_balita' => 'Budi Jr',
            'nik' => '1111111111111111', // duplicate child NIK
            'tanggal_lahir' => '2025-01-01',
            'jenis_kelamin' => 'L',
            'nama_ibu' => $mother->nama_ibu,
            'nik_ibu' => $mother->nik,
            'no_hp' => $mother->no_hp,
            'alamat' => $mother->alamat,
        ]);
        $response->assertSessionHasErrors(['nik']);
        $errors = session('errors')->get('nik');
        $this->assertEquals('NIK sudah terdaftar atau digunakan.', $errors[0]);
    }

    /**
     * Test Balita update validation rules.
     */
    public function test_balita_update_validation()
    {
        $this->actingAs($this->user);

        // Create Mother
        $mother = IbuHamil::create([
            'nama_ibu' => 'Siti Aminah',
            'nik' => '1234567890123456',
            'tanggal_lahir' => '1990-05-15',
            'alamat' => 'Jl. Kenanga No. 5',
            'no_hp' => '081299998888',
            'gravida' => 2,
            'partus' => 1,
            'abortus' => 0,
            'hpht' => '2026-01-01',
            'created_by' => $this->user->id,
        ]);

        // Create Child
        $child = Balita::create([
            'ibu_hamil_id' => $mother->id,
            'nama_balita' => 'Budi',
            'nik' => '1111111111111111',
            'tanggal_lahir' => '2025-01-01',
            'jenis_kelamin' => 'L',
            'nama_ibu' => $mother->nama_ibu,
            'nik_ibu' => $mother->nik,
            'no_hp_ortu' => $mother->no_hp,
            'alamat' => $mother->alamat,
            'created_by' => $this->user->id,
        ]);

        // Update child section, keeping NIK. Should succeed!
        $response = $this->put(route('balita.update', $child->id), [
            '_section' => 'balita',
            'nama_balita' => 'Budi Updated',
            'nik' => '1111111111111111',
            'tanggal_lahir' => '2025-01-01',
            'jenis_kelamin' => 'L',
        ]);
        $response->assertRedirect(route('balita.index'));
        $this->assertDatabaseHas('balita', [
            'id' => $child->id,
            'nama_balita' => 'Budi Updated',
        ]);

        // Update parent section, keeping mother. Should succeed!
        $response = $this->put(route('balita.update', $child->id), [
            '_section' => 'ortu',
            'ibu_hamil_id' => $mother->id,
            'nama_ibu' => $mother->nama_ibu,
            'nik_ibu' => $mother->nik,
            'no_hp' => $mother->no_hp,
            'alamat' => $mother->alamat,
        ]);
        $response->assertRedirect(route('balita.index'));
        $this->assertDatabaseHas('balita', [
            'id' => $child->id,
            'nik_ibu' => $mother->nik,
        ]);
    }
}
