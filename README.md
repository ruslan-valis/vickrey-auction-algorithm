# Vickrey auction algorithm
> Algorithm implementation for finding the winner and the winner price in the Vickery auction

## Problem
Let's consider a second-price, sealed-bid auction:
- An object for sale with a reserve price.
- We have several potentital buyers, each one being able to place one or more bids.
- The buyer winning the auction is the one with the highest bid above or equal to the reserve price.
- The winning price is the highest bid price from a non-winning buyer above the reserve price (or the reserve price if none applies).

## Example
Consider 5 potential buyers (A, B, C, D, E) with complete to acquire an object with a reserve price set at 100 euros, bidding as follows:

| Buyer | Bid 1 | Bid 2 | Bid 3 |
|-------|-------|-------|-------|
| A     | 110   | 130   |       |
| B     |       |       |       |
| C     | 125   |       |       |
| D     | 105   | 115   | 90    |
| E     | 132   | 135   | 130   |

The buyer E wins the auction at the price of 130 euros.

## Goal
The goal is to implement the algorithm for finding the winner and the winning price.
