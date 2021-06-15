Feature: Calculate shopping basket totals after taxes
  Basic sales tax is applicable at a rate of 10% on all goods, except books, food,
  and medical products that are exempt. Import duty is an additional sales tax applicable
  on all imported goods at a rate of 5%, with no exemptions.

  Scenario: As user, I want to process stored pre-tax shopping basket and save corresponding receipts, so I can pass this test.
    Given shopping baskets in "./test/shoppingBaskets"
    When I run the command "reviva:process-shopping-baskets" with arguments "./test/shoppingBaskets" and "/tmp"
    Then receipts in "/tmp" should match those in "./test/receipts"
