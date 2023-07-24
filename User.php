<?php

class User
{
    private string $id;
    private string $name;
    private string $email;
    private string $password;
    private string $address;
    private string $phone;
    private int $age;
    private bool $admin;

    public function __construct(string $name, int $age, string $email, string $password, bool $admin, string $address, string $phone)
    {
        $this->name = $name;
        $this->age = $age;
        $this->email = $email;
        $this->password = $password;
        $this->admin = $admin;
        $this->address = $address;
        $this->phone = $phone;
        $this->id = hash('sha1', $this->name);
    }

    public function get_data(): array
    {
        $data = [
            'name' => $this->name,
            'age' => $this->age,
            'email' => $this->email,
            'password' => $this->password,
            'admin' => $this->admin,
            'address' => $this->address,
            'phone' => $this->phone
        ];

        return $data;
    }
}
