<?php

namespace Kl;

class UserDbTable implements \Kl\DbTable
{
    private array $storage = [
        [
            'id' => 1,
            'email' => 'testuser1@test.com',
            'balance' => 120.45
        ],
        [
            'id' => 2,
            'email' => 'testuser2@test.com',
            'balance' => 9999.45
        ],
        [
            'id' => 3,
            'email' => 'testuser3@test.com',
            'balance' => 0.45
        ],
        [
            'id' => 4,
            'email' => 'testuser4@test.com',
            'balance' => 1111.45
        ]
    ];

    public function getStorage() :array
    {
        return $this->storage;
    }

    public function update(array $userData)
    {
        foreach ($this->getStorage() as $index => $item) {
            if (isset($item['id']) && $item['id'] === $userData['id']) {
                unset($userData['id']);
                $this->storage[$index] = $userData;
                return true;
            }
        }

        $msg = sprintf('User %s not found', $userData['id']);

        error_log($msg);

        throw new \Exception($msg);
    }

    /**
     * Add user.
     *
     * @param  array  $user
     * @return bool
     */
    public function add(array $user)
    {
        if (empty($user['id'])) {
            $user['id'] = count($this->getStorage()) + 1;
        }

        return
            ($this->storage[] = $user) ? true : false;
    }
}
