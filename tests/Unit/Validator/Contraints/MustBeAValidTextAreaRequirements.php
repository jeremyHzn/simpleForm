<?php

declare(strict_types=1);

use App\Validator\Constraints\MustBeAValidTextAreaRequirement;
use Symfony\Component\Validator\Validation;

beforeEach(function () {
    $this->validator = Validation::createValidator();
});

test(
    description: 'Valid values pass MustBeAValidTextAreaRequirement constraint',
    closure: function (?string $value) {
        $violations = $this
            ->validator
            ->validate(
                value: $value,
                constraints: [
                    new MustBeAValidTextAreaRequirement(),
                ]
            );

        expect(
            value: $violations
        )->toBeEmpty();
    }
)->with(
    data: [
        null,
        '',
        "Longueur inférieure à 4000 caractères"
    ]
);

test(
    description: 'Invalid types of values does not pass MustBeAValidTextAreaRequirement constraint',
    closure: function (mixed $value) {
        $violations = $this
            ->validator
            ->validate(
                value: $value,
                constraints: [
                    new MustBeAValidTextAreaRequirement(),
                ]
            );

        expect(
            value: $violations
        )
            ->toHaveCount(
                count: 1
            )
            ->and($violations[0]->getMessage())
            ->toBe(
                expected: 'This value should be of type string.'
            );
    }
)->with(
    data: [
        0,
        false,
        true,
    ]
);

test(
    description: 'Too long text does not pass MustBeAValidTextAreaRequirement constraint',
    closure: function (string $value) {
        $violations = $this
            ->validator
            ->validate(
                value: $value,
                constraints: [
                    new MustBeAValidTextAreaRequirement(),
                ]
            );

        expect(
            value: $violations
        )
            ->toHaveCount(
                count: 1
            )
            ->and($violations[0]->getMessage())
            ->toBe(
                expected: 'This value is too long. It should have 4000 characters or less.'
            );
    }
)->with(
    data: [
        "Le monde est en constante évolution et chaque jour apporte de nouvelles découvertes et des changements significatifs dans notre société. De la technologie à la culture, de la science à l'art, il y a tellement de domaines qui façonnent notre réalité. Dans ce texte, nous allons explorer quelques-uns de ces domaines et réfléchir à leur impact sur notre vie quotidienne. Commençons par la technologie. Les avancées technologiques ont révolutionné la façon dont nous communiquons, travaillons et vivons. Les smartphones sont devenus omniprésents et ont transformé la manière dont nous interagissons les uns avec les autres. Grâce aux applications de messagerie instantanée et aux réseaux sociaux, nous pouvons rester connectés en permanence, peu importe où nous nous trouvons dans le monde. De plus, l'intelligence artificielle progresse rapidement, ouvrant de nouvelles perspectives dans des domaines tels que la santé, les transports et l'éducation. En parlant de santé, la médecine a également connu des avancées spectaculaires. Les chercheurs ont découvert de nouveaux traitements pour des maladies autrefois incurables, prolongeant ainsi l'espérance de vie et améliorant la qualité de vie de millions de personnes. Les progrès dans le domaine de la génomique ont permis de mieux comprendre notre code génétique, ce qui ouvre la voie à une médecine personnalisée et à des thérapies ciblées. De plus, les dispositifs médicaux connectés et les applications de santé mobiles nous aident à surveiller notre condition physique et à prendre soin de notre bien-être de manière proactive. Le monde des affaires a également subi des changements considérables. La mondialisation a ouvert de nouvelles possibilités commerciales et a favorisé la croissance économique dans de nombreux pays. Les plateformes de commerce électronique ont connu une expansion rapide, offrant aux consommateurs un accès facile à une grande variété de produits et de services. Les start-ups technologiques jouent un rôle de plus en plus important dans l'économie, en développant des innovations disruptives et en stimulant la concurrence. Le monde est en constante évolution et chaque jour apporte de nouvelles découvertes et des changements significatifs dans notre société. De la technologie à la culture, de la science à l'art, il y a tellement de domaines qui façonnent notre réalité. Dans ce texte, nous allons explorer quelques-uns de ces domaines et réfléchir à leur impact sur notre vie quotidienne. Commençons par la technologie. Les avancées technologiques ont révolutionné la façon dont nous communiquons, travaillons et vivons. Les smartphones sont devenus omniprésents et ont transformé la manière dont nous interagissons les uns avec les autres. Grâce aux applications de messagerie instantanée et aux réseaux sociaux, nous pouvons rester connectés en permanence, peu importe où nous nous trouvons dans le monde. De plus, l'intelligence artificielle progresse rapidement, ouvrant de nouvelles perspectives dans des domaines tels que la santé, les transports et l'éducation. En parlant de santé, la médecine a également connu des avancées spectaculaires. Les chercheurs ont découvert de nouveaux traitements pour des maladies autrefois incurables, prolongeant ainsi l'espérance de vie et améliorant la qualité de vie de millions de personnes. Les progrès dans le domaine de la génomique ont permis de mieux comprendre notre code génétique, ce qui ouvre la voie à une médecine personnalisée et à des thérapies ciblées. De plus, les dispositifs médicaux connectés et les applications de santé mobiles nous aident à surveiller notre condition physique et à prendre soin de notre bien-être de manière proactive. Le monde des affaires a également subi des changements considérables. La mondialisation a ouvert de nouvelles possibilités commerciales et a favorisé la croissance économique dans de nombreux pays. Les plateformes de commerce électronique ont connu une expansion rapide, offrant aux consommateurs un accès facile à une grande variété de produits et de services. Les start-ups technologiques jouent un rôle de plus en plus important dans l'économie, en développant des innovations disruptives et en stimulant la concurrence."
    ]
);