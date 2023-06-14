<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class QuestionControllerTest extends WebTestCase
{
    private const INVALID_EMAIL_MESSAGE = 'This value is not a valid email address.';

    private const INVALID_CHOICE_MESSAGE = 'The selected choice is invalid.';

    private const TOO_LONG_TEXT_MESSAGE = 'This value is too long. It should have 4000 characters or less.';

    private const EMAIL_CANNOT_BE_USED_MESSAGE = 'The email "webtestcase@example.com" cannot be used. Please enter another email.';

    private ?KernelBrowser $client = null;

    private ?QuestionRepository $questionRepository = null;

    protected function setUp(): void
    {
        $this->client = QuestionControllerTest::createClient();

        $this->questionRepository = QuestionControllerTest::getContainer()
            ->get(
                id: 'doctrine'
            )
            ->getManager()
            ->getRepository(Question::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->client = null;

        $this->questionRepository = null;
    }

    public function test_form_is_displayed_correctly(): void
    {
        $crawler = $this
            ->client
            ->request(
                method: Request::METHOD_GET,
                uri: '/'
            );

        $this->assertResponseIsSuccessful();

        $this->assertCount(
            expectedCount: 1,
            haystack: $crawler->filter(
                selector: 'form[name="satisfaction_form"]'
            )
        );

        $this->assertCount(
            expectedCount: 1,
            haystack: $crawler->filter(
                selector: 'input[name="satisfaction_form[email]"]'
            )
        );

        $this->assertCount(
            expectedCount: 10,
            haystack: $crawler->filter(
                selector: 'input[name="satisfaction_form[question1]"]'
            )
        );

        $this->assertCount(
            expectedCount: 3,
            haystack: $crawler->filter(
                selector: 'input[name="satisfaction_form[question2]"]'
            )
        );

        $this->assertCount(
            expectedCount: 1,
            haystack: $crawler->filter(
                selector: 'textarea[name="satisfaction_form[question3]"]'
            )
        );

        $this->assertCount(
            expectedCount: 1,
            haystack: $crawler->filter(
                selector: 'button[type="submit"]'
            )
        );
    }

    public function test_invalid_data_submitted_should_result_on_redirection_to_the_form_with_the_entered_data_saved_and_errors_displayed(): void
    {
        $submittedDataFromForm = [
            'satisfaction_form[email]' => 'webtestcase@example',
            'satisfaction_form[question1]' => 'toto',
            'satisfaction_form[question2]' => 100,
            'satisfaction_form[question3]' => "Le monde est en constante évolution et chaque jour apporte de nouvelles découvertes et des changements significatifs dans notre société. De la technologie à la culture, de la science à l'art, il y a tellement de domaines qui façonnent notre réalité. Dans ce texte, nous allons explorer quelques-uns de ces domaines et réfléchir à leur impact sur notre vie quotidienne. Commençons par la technologie. Les avancées technologiques ont révolutionné la façon dont nous communiquons, travaillons et vivons. Les smartphones sont devenus omniprésents et ont transformé la manière dont nous interagissons les uns avec les autres. Grâce aux applications de messagerie instantanée et aux réseaux sociaux, nous pouvons rester connectés en permanence, peu importe où nous nous trouvons dans le monde. De plus, l'intelligence artificielle progresse rapidement, ouvrant de nouvelles perspectives dans des domaines tels que la santé, les transports et l'éducation. En parlant de santé, la médecine a également connu des avancées spectaculaires. Les chercheurs ont découvert de nouveaux traitements pour des maladies autrefois incurables, prolongeant ainsi l'espérance de vie et améliorant la qualité de vie de millions de personnes. Les progrès dans le domaine de la génomique ont permis de mieux comprendre notre code génétique, ce qui ouvre la voie à une médecine personnalisée et à des thérapies ciblées. De plus, les dispositifs médicaux connectés et les applications de santé mobiles nous aident à surveiller notre condition physique et à prendre soin de notre bien-être de manière proactive. Le monde des affaires a également subi des changements considérables. La mondialisation a ouvert de nouvelles possibilités commerciales et a favorisé la croissance économique dans de nombreux pays. Les plateformes de commerce électronique ont connu une expansion rapide, offrant aux consommateurs un accès facile à une grande variété de produits et de services. Les start-ups technologiques jouent un rôle de plus en plus important dans l'économie, en développant des innovations disruptives et en stimulant la concurrence. Le monde est en constante évolution et chaque jour apporte de nouvelles découvertes et des changements significatifs dans notre société. De la technologie à la culture, de la science à l'art, il y a tellement de domaines qui façonnent notre réalité. Dans ce texte, nous allons explorer quelques-uns de ces domaines et réfléchir à leur impact sur notre vie quotidienne. Commençons par la technologie. Les avancées technologiques ont révolutionné la façon dont nous communiquons, travaillons et vivons. Les smartphones sont devenus omniprésents et ont transformé la manière dont nous interagissons les uns avec les autres. Grâce aux applications de messagerie instantanée et aux réseaux sociaux, nous pouvons rester connectés en permanence, peu importe où nous nous trouvons dans le monde. De plus, l'intelligence artificielle progresse rapidement, ouvrant de nouvelles perspectives dans des domaines tels que la santé, les transports et l'éducation. En parlant de santé, la médecine a également connu des avancées spectaculaires. Les chercheurs ont découvert de nouveaux traitements pour des maladies autrefois incurables, prolongeant ainsi l'espérance de vie et améliorant la qualité de vie de millions de personnes. Les progrès dans le domaine de la génomique ont permis de mieux comprendre notre code génétique, ce qui ouvre la voie à une médecine personnalisée et à des thérapies ciblées. De plus, les dispositifs médicaux connectés et les applications de santé mobiles nous aident à surveiller notre condition physique et à prendre soin de notre bien-être de manière proactive. Le monde des affaires a également subi des changements considérables. La mondialisation a ouvert de nouvelles possibilités commerciales et a favorisé la croissance économique dans de nombreux pays. Les plateformes de commerce électronique ont connu une expansion rapide, offrant aux consommateurs un accès facile à une grande variété de produits et de services. Les start-ups technologiques jouent un rôle de plus en plus important dans l'économie, en développant des innovations disruptives et en stimulant la concurrence."
        ];

        $crawler = $this
            ->client
            ->request(
                method: Request::METHOD_GET,
                uri: '/'
            );

        $this->assertResponseIsSuccessful();

        $form = $crawler
            ->selectButton(
                value: 'Envoyer'
            )
            ->form();

        $form->disableValidation();

        $form->setValues(
            values: $submittedDataFromForm
        );

        $this
            ->client
            ->submit(
                form: $form
            );

        $this->assertResponseStatusCodeSame(
            expectedCode: Response::HTTP_FOUND
        );

        $this
            ->client
            ->followRedirect();

        $this->assertResponseIsSuccessful();

        $crawler = $this
            ->client
            ->getCrawler();

        $this->assertEquals(
            expected: $submittedDataFromForm['satisfaction_form[email]'],
            actual: $crawler
                ->filter(
                    selector: 'input[name="satisfaction_form[email]"]'
                )
                ->attr(
                    attribute: 'value'
                )
        );

        $this->assertStringContainsString(
            needle: self::INVALID_EMAIL_MESSAGE,
            haystack: $crawler
                ->filter(
                    selector: 'ul li'
                )
                ->eq(
                    position: 0
                )
                ->text()
        );

        $this->assertCount(
            expectedCount: 0,
            haystack: $crawler
                ->filter(
                    selector: 'input[name="satisfaction_form[question1]"]:checked'
                )
        );

        $this->assertSame(
            expected: '2',
            actual: $crawler
                ->filter(
                    selector: 'input[name="satisfaction_form[question2]"]:checked'
                )
                ->attr(
                    attribute: 'value'
                )
        );

        foreach ([1, 2] as $value) {
            $this->assertStringContainsString(
                needle: self::INVALID_CHOICE_MESSAGE,
                haystack: $crawler
                    ->filter(
                        selector: 'ul li'
                    )
                    ->eq(
                        position: $value
                    )
                    ->text()
            );
        }

        $this->assertEquals(
            expected: $submittedDataFromForm['satisfaction_form[question3]'],
            actual: $crawler
                ->filter(
                    selector: 'textarea[name="satisfaction_form[question3]"]'
                )
                ->text()
        );

        $this->assertStringContainsString(
            needle: self::TOO_LONG_TEXT_MESSAGE,
            haystack: $crawler
                ->filter(
                    selector: 'ul li'
                )
                ->eq(
                    position: 3
                )
                ->text()
        );
    }

    public function test_valid_data_submitted_should_result_on_redirection_to_the_form_with_flash_message_displayed(): void
    {
        $this->commonLogic();
    }

    public function test_valid_data_submitted_with_existing_email_should_result_on_redirection_to_the_form_with_error_displayed_on_email_field(): void
    {
        $submittedDataFromForm = $this->commonLogic();

        $crawler = $this
            ->client
            ->submitForm(
                button: 'Envoyer',
                fieldValues: $submittedDataFromForm
            );

        $this->assertResponseIsSuccessful();

        $this->assertEquals(
            expected: $submittedDataFromForm['satisfaction_form[email]'],
            actual: $crawler
                ->filter(
                    selector: 'input[name="satisfaction_form[email]"]'
                )
                ->attr(
                    attribute: 'value'
                )
        );

        $this->assertStringContainsString(
            needle: self::EMAIL_CANNOT_BE_USED_MESSAGE,
            haystack: $crawler
                ->filter(
                    selector: 'ul li'
                )
                ->eq(
                    position: 0
                )
                ->text()
        );
    }

    private function commonLogic(): array
    {
        $submittedDataFromForm = [
            'satisfaction_form[email]' => 'webtestcase@example.com',
            'satisfaction_form[question1]' => '1',
            'satisfaction_form[question2]' => '1',
            'satisfaction_form[question3]' => 'OK'
        ];

        $this
            ->client
            ->request(
                method: Request::METHOD_GET,
                uri: '/'
            );

        $this
            ->client
            ->followRedirects();

        $this->assertResponseIsSuccessful();

        $this
            ->client
            ->submitForm(
                button: 'Envoyer',
                fieldValues: $submittedDataFromForm
            );

        $this->assertResponseIsSuccessful();

        $this->assertSelectorExists(
            selector: 'div[class="notice-success"]'
        );

        $this->assertSelectorTextContains(
            selector: 'div[class="notice-success"]',
            text: 'Merci pour votre retour !'
        );

        $questionInstance = $this
            ->questionRepository
            ->findOneBy(
                criteria: [
                    'email' => $submittedDataFromForm['satisfaction_form[email]']
                ]
            );

        $this->assertInstanceOf(
            expected: Question::class,
            actual: $questionInstance
        );

        return $submittedDataFromForm;
    }
}