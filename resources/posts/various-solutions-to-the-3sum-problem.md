---
title: "Various Solutions to the 3SUM Problem"
slug: various-solutions-to-the-3sum-problem
tags: tech algorithms java
published: "2024-03-03 06:41"
updated: "2024-03-03 19:23"
---

I've seen three different variations of the 3-sum problem.  In order of increasing complexity:

Given an array of integers,

1. Do **any** three sum to zero?
2. **How many** triplets sum to zero?
3. **Which** distinct triplets sum to zero?

Let's solve #3.

First, let's be more precise.  LeetCode defines the problem thus:

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

## Hashmap

Here, we loop through the `nums` array and make a map of values to all indices they appear in. We have the two `i` and `j` loops as before, but we can (mostly) skip the `k` loop.

Since we already have two values (`ival` and `jval`), we can simply compute the difference `(ival + jval) * -1` and check if it's in the hashmap. Since the hashmap will return a list of values, we will need to have a third loop.

- **Time complexity**: O(n^3)
- **Space complexity**: O(n)

Note that the worst case time complexity is no better than brute force.  And with worse space complexity! The difference is that the brute force algorithm *always* runs in O(n^3). For "reasonable" inputs, the amortized time complexity of the hashmap version is much better.

```java 
    public List<List<Integer>> threeSum(int[] nums) {
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
    }
```

## Binary Search

This is similar to the hashmap version, but instead of looking up the values in a hashmap, we binary search the input array (that we should have already sorted). Again, we calculate the difference between `i + j` and 0 (`(nums[i] + nums[j]) * -1`). This is what we will binary search the array for.

The outer two loops run in n^2 time.  Binary search takes log n time. Multiplying these together,

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

## Quadratic Algorithm

The quadratic algorithm takes a completely different approach.  For each element of the array, we create two pointers that point the first and last elements of the remaining elements.  In the inner loop, we increment the start pointer and decrement the end pointer if a triplet sums to zero.

If the sum is less than zero, we know we need to increment the start pointer. The array is sorted, so the only way to get a larger sum is to increment the lower pointer. Likewise, if the sum is greater than zero, we need to decrement the end pointer to try to find a lower value.

- **Time complexity**: O(n^2)
- **Space complexity**: O(1)

```java
    public List<List<Integer>> threeSum(int[] nums) {
        Arrays.sort(nums);
        final List<List<Integer>> results = new ArrayList<>();

        for (int i = 0; i < nums.length - 2; i++) {
            final int ival = nums[i];
            int start = i + 1;
            int end = nums.length - 1;

            while (start < end) {
                final int jval = nums[start];
                final int kval = nums[end];

                if (ival + jval + kval == 0) {
                    results.add(Arrays.asList(ival, jval, kval));
                    start++;
                    end--;
                }
                else if (ival + jval + kval > 0) {
                    end--;
                }
                else {
                    start++;
                }
            }
        }

        return results;
    }
```


