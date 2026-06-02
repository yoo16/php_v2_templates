<?php
class BaseCard
{
    public int $level = 1;
    public string $name = '';
    public int $attack = 0;
    public int $defense = 0;
    public int $hp = 0;
    public int $maxHp = 0;
    public int $mp = 0;
    public int $maxMp = 0;
    public int $exp = 0;
    public string $element = '';
    public string $image = '';
    public string $specialSkill = '';
    public int $specialSkillPower = 0;
    public array $levelUpThresholds = [20, 50, 90, 150, 220, 300, 400, 500, 700, 1000];

    /**
     * 子クラスから送られてきた値でプロパティを初期化する
     */
    public function __construct(
        string $name,
        int $attack,
        int $defense,
        int $hp,
        int $mp,
        string $element,
        string $image,
        string $specialSkill,
        int $specialSkillPower
    ) {
        $this->level = 1;
        $this->exp = 0;
        $this->name = $name;
        $this->attack = $attack;
        $this->defense = $defense;
        $this->hp = $hp;
        $this->maxHp = $hp;
        $this->mp = $mp;
        $this->maxMp = $mp;
        $this->element = $element;

        // 画像パスの処理: URLでなければ ./images/ フォルダを参照する
        if (str_starts_with($image, 'http')) {
            $this->image = $image;
        } else {
            $this->image = 'images/' . $image;
        }

        $this->specialSkill = $specialSkill;
        $this->specialSkillPower = $specialSkillPower;
    }

    public function showStatus(): string
    {
        $message = "";
        $message .= "名前: " . $this->name . "\n";
        $message .= "レベル: " . $this->level . "\n";
        $message .= "攻撃力: " . $this->attack . "\n";
        $message .= "防御力: " . $this->defense . "\n";
        $message .= "HP: " . $this->hp . " / " . $this->maxHp . "\n";
        $message .= "MP: " . $this->mp . " / " . $this->maxMp . "\n";
        $message .= "経験値: " . $this->exp . "\n";
        $message .= "属性: " . $this->element . "\n";
        $message .= "画像: " . $this->image . "\n";
        $message .= "必殺技: " . $this->specialSkill . "\n";
        $message .= "必殺技威力: " . $this->specialSkillPower . "\n";
        return $message;
    }

    public function attack(BaseCard $target): int
    {
        // ダメージ計算: (攻撃力 * 1.5 - 相手の防御力) + 乱数
        $baseDmg = ($this->attack * 1.5) - $target->defense;
        $random = rand(-5, 5);
        $dmg = (int)($baseDmg + $random);

        // 最低ダメージ保証 (攻撃力の 20%)
        $minDmg = (int)($this->attack * 0.2);
        if ($dmg < $minDmg) $dmg = $minDmg;

        $target->hp -= $dmg;
        if ($target->hp < 0) $target->hp = 0;

        return $dmg;
    }

    public function specialSkill(BaseCard $target): int
    {
        if ($this->mp <= 0) return 0;
        $this->mp--;

        // スキルダメージ: (スキル威力 * 1.2 - 相手の防御力 * 0.5)
        $baseDmg = ($this->specialSkillPower * 1.2) - ($target->defense * 0.5);
        $random = rand(-10, 10);
        $dmg = (int)($baseDmg + $random);

        if ($dmg < 0) $dmg = 0;
        $target->hp -= $dmg;
        if ($target->hp < 0) $target->hp = 0;

        return $dmg;
    }

    public function gainExp(int $exp): void
    {
        // TODO: 経験値を加算
    }

    public function isLevelUp(): bool
    {
        if ($this->level >= 10) return false;
        return $this->exp >= $this->levelUpThresholds[$this->level - 1];
    }

    public function levelUp(): void
    {
        // TODO: レベルアップの処理: level
        // TODO: 攻撃力と防御力を増加: attack, defense
        // TODO: 最大HPを増加: maxHp
        // TODO: 最大MPを増加: maxMp

        // 全回復
        $this->hp = $this->maxHp; 
        $this->mp = $this->maxMp;
    }
}
