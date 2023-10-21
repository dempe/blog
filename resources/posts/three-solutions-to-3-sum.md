---
title: "Three Solutions to 3-Sum"
slug: three-solutions-to-3-sum
tags: tech algorithms java
published: 1697839715
---

I've seen three[^1] different variations of the 3-sum problem.  In order of increasing complexity:

Given an array of integers,

1. Do **any** three sum to zero?
2. **How many** triplets sum to zero?
3. **Which** distinct triplets sum to zero?

Sticking with our theme (_threem_[^2] anyone...?), let's solve #3.

But first, let's be more precise.  LeetCode defines the problem thus:

> Given an integer array `nums`, return all triplets `[nums[i], nums[j], nums[k]]` such that `i != j`, `i != k`, `j != k`, and `nums[i] + nums[j] + nums[k] == 0`.

## Brute Force

For the brute force solution, just loop over the array checking each triplet. If a triplet sums to 0, add it to our set (we're using a set to prevent adding duplicate triplets).  Start `j` at `i + 1` and `k` at `j + 1` to avoid looking at indices more than once.

- **Time complexity**: O(n^3)
- **Space complexity**: O(1)

```java 
    public List<List<Integer>> threeSum(int[] nums) {
        // First, sort the array so that the triplets will also be sorted.
        // This ensures that the hash set will reject any non-distinct triplets.
        Arrays.sort(nums);
        final Set<List<Integer>> results = new HashSet<>();

        for (int i = 0; i < nums.length; i++) {
            for (int j = i + 1; j < nums.length; j++) {
                for (int k = j + 1; k < nums.length; k++) {
                    final int ival = nums[i];
                    final int jval = nums[j];
                    final int kval = nums[k];

                    if (ival + jval + kval != 0) { continue; }

                    results.add(Arrays.asList(ival, jval, kval));
                }
            }
        }

        return new ArrayList<>(results);
    }
```

## Binary Search

Instead, we can sort `nums` at the start of the function. We need to do this to use binary search later. After that we have the same two outer loops for `i` and `j` like we did in the brute force solution.

But here, instead of looping through the array again, we can simply calculate the difference between `i + j` and 0, specifically, `(nums[i] + nums[j]) * -1`.  Since `nums` is sorted, we can now use binary search to look for the missing value. `binarySearch` doesn't know what indices we've processed.  We've already processed anything less than or equal to `j`, so after we run `binarySearch`, we need to increment `k` until it's greater than `j`.

The outer two loops run in n^2 time.  Binary search takes log n time. Multiplying these together, this solution has a..

- **Time complexity**: O(n^2 log n)
- **Space complexity**: O(1)

```java
    public List<List<Integer>> threeSum(int[] nums) {
        Arrays.sort(nums);
        final Set<List<Integer>> results = new HashSet<>();

        for (int i = 0; i < nums.length; i++) {
            for (int j = i + 1; j < nums.length; j++) {
                final int ival = nums[i];
                final int jval = nums[j];
                final int kval = (ival + jval) * -1;

                int k = Arrays.binarySearch(nums, kval);

                if (k < 0) { continue; }    // Not found             
                if (k <= j ) { k = j + 1; } // If k is less than or equal to j, we have already processed this index.
                if (k >= nums.length || nums[k] != kval) { continue; }

                results.add(Arrays.asList(ival, jval, kval));
            }
        }

        return new ArrayList<>(results);
    }
```

## Hashmap

This is similar to the binary search solution. We make a map of values to all indices they appear in. We compute the `k` value the same as in the binary search method, but look for it in the map, instead.

This method is faster than the binary search method, but uses more space, so there is a space/time tradeoff to make.

- **Time complexity**: O(n^2)
- **Space complexity**: O(n)

```java 
        Arrays.sort(nums);
        final Set<List<Integer>> results = new HashSet<>();
        final Map<Integer, List<Integer>> valuesToIndices = new HashMap<>();

        for (int i = 0; i < nums.length; i++) {
            valuesToIndices.putIfAbsent(nums[i], new ArrayList<>());
            valuesToIndices.get(nums[i]).add(i);
        }

        for (int i = 0; i < nums.length; i++) {
            for (int j = i + 1; j < nums.length; j++) {
                final int ival = nums[i];
                final int jval = nums[j];
                final int kval = (ival + jval) * -1;
                final List<Integer> candidates = valuesToIndices.getOrDefault(kval, null);

                // candidates should never be empty, but check just in case.
                if (candidates == null || candidates.isEmpty()) { continue; } // Not found

                for (final int k : candidates) {
                    if (k <= j) { continue; }
                    results.add(Arrays.asList(ival, jval, kval));
                    break;
                }
            }
        }

        return new ArrayList<>(results);
```

## Footnotes

[^1]: The number "3" seems to be a theme with this post -- three sum, three solutions, three variations.

[^2]: I'm a dad now I can make these jokes.






