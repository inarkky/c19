<?php

namespace application\helpers;


use Exception;

class Math
{
    const POPULATION = true;
    const SAMPLE     = false;

    const SAMPLE_SKEWNESS      = 'sample';
    const POPULATION_SKEWNESS  = 'population';
    const ALTERNATIVE_SKEWNESS = 'alternative';

    const SAMPLE_KURTOSIS     = 'sample';
    const POPULATION_KURTOSIS = 'population';

    /**
     * Range - the difference between the largest and smallest values
     * 
     * R = max x - min x
     */
    public static function range(array $numbers): float
    {
        if (empty($numbers)) {
            throw new Exception('Cannot find the range of an empty list of numbers');
        }
        return max($numbers) - min($numbers);
    }

    /**
     * Midrange - the mean of the largest and smallest values
     * 
     *     max x + min x
     * M = -------------
     *           2
     */
    public static function midrange(array $numbers): float
    {
        if (empty($numbers)) {
            throw new Exception('Cannot find the midrange of an empty list of numbers');
        }
        return self::mean([min($numbers), max($numbers)]);
    }

    /**
     * Variance
     * 
     *      ∑(xᵢ - μ)²
     * σ² = ----------
     *          ν
     */
    public static function variance(array $numbers, int $ν): float
    {
        if (empty($numbers)) {
            throw new Exception('Cannot find the variance of an empty list of numbers');
        }
        if ($ν <= 0) {
            throw new Exception('Degrees of freedom must be > 0');
        }

        $∑xμ = self::sumOfSquaresDeviations($numbers);
    
        return $∑xμ / $ν;
    }

    /**
     * Population variance - Use when all possible observations of the system are present
     *      ∑(xᵢ - μ)²
     * σ² = ----------
     *          N
     */
    public static function populationVariance(array $numbers): float
    {
        $N = count($numbers);
        return self::variance($numbers, $N);
    }

    /**
     * Unbiased sample variance
     * 
     *      ∑(xᵢ - x̄)²
     * S² = ----------
     *        n - 1
     */
    public static function sampleVariance(array $numbers): float
    {
        if (count($numbers) == 1) {
            return 0;
        }

        $n = count($numbers);
        return self::variance($numbers, $n - 1);
    }

    /**
     * Weighted sample variance
     *
     * Biased case
     *
     *       ∑wᵢ(xᵢ - μw)²
     * σ²w = ----------
     *           ∑wᵢ
     *
     * Unbiased estimator for frequency weights
     *
     *       ∑wᵢ(xᵢ - μw)²
     * σ²w = ----------
     *         ∑wᵢ - 1
     */
    public static function weightedSampleVariance(array $numbers, array $weights, bool $biased = false): float
    {
        if (count($numbers) === 1) {
            return 0;
        }
        if (count($numbers) !== count($weights)) {
            throw new Exception('Numbers and weights must have the same number of elements.');
        }

        $μw           = self::weightedMean($numbers, $weights);
        $∑wxμw = array_sum(array_map(
            function ($xi, $wi) use ($μw) {
                return $wi * pow(($xi - $μw), 2);
            },
            $numbers,
            $weights
        ));

        $∑wi = $biased
            ? array_sum($weights)
            : array_sum($weights) - 1;

        return $∑wxμw / $∑wi;
    }

    /**
     * Standard deviation
     * 
     * σ   = √(σ²) = √(variance)
     * SD+ = √(σ²) = √(sample variance)
     */
    public static function standardDeviation(array $numbers, bool $SD＋ = false): float
    {
        if (empty($numbers)) {
            throw new Exception('Cannot find the standard deviation of an empty list of numbers');
        }

        return $SD＋
            ? sqrt(self::populationVariance($numbers))
            : sqrt(self::sampleVariance($numbers));
    }

    /**
     * Mean absolute deviation
     * 
     *       ∑|xᵢ - x̄|
     * MAD = ---------
     *           N
     */
    public static function meanAbsoluteDeviation(array $numbers): float
    {
        if (empty($numbers)) {
            throw new Exception('Cannot find the mean absolute deviation of an empty list of numbers');
        }

        $x         = self::mean($numbers);
        $∑xx = array_sum(array_map(
            function ($xi) use ($x) {
                return abs($xi - $x);
            },
            $numbers
        ));
        $N = count($numbers);

        return $∑xx / $N;
    }

    /**
     * MAD - median absolute deviation
     * 
     * MAD = median(|xᵢ - x̄|)
     */
    public static function medianAbsoluteDeviation(array $numbers): float
    {
        if (empty($numbers)) {
            throw new Exception('Cannot find the median absolute deviation of an empty list of numbers');
        }

        $x = self::median($numbers);
        return self::median(array_map(
            function ($xi) use ($x) {
                return abs($xi - $x);
            },
            $numbers
        ));
    }

    /**
     * Quartiles
     */
    public static function quartiles(array $numbers, string $method = 'exclusive'): array
    {
        switch (strtolower($method)) {
            case 'inclusive':
                return self::quartilesInclusive($numbers);
            case 'exclusive':
                return self::quartilesExclusive($numbers);
            default:
                return self::quartilesExclusive($numbers);
        }
    }

    /**
     * Quartiles - Exclusive method
     */
    public static function quartilesExclusive(array $numbers): array
    {
        if (empty($numbers)) {
            throw new Exception('Cannot find the quartiles of an empty list of numbers');
        }
        if (count($numbers) === 1) {
            $number = array_pop($numbers);
            return [
                'percent0'   => $number,
                'Q1'   => $number,
                'Q2'   => $number,
                'Q3'   => $number,
                'percent100' => $number,
                'IQR'  => 0,
            ];
        }

        sort($numbers);
        $length = count($numbers);

        if ($length % 2 == 0) {
            $lower_half = array_slice($numbers, 0, $length / 2);
            $upper_half = array_slice($numbers, $length / 2);
        } else {
            $lower_half = array_slice($numbers, 0, intdiv($length, 2));
            $upper_half = array_slice($numbers, intdiv($length, 2) + 1);
        }

        $lower_quartile = self::median($lower_half);
        $upper_quartile = self::median($upper_half);

        return [
            'percent0'   => min($numbers),
            'Q1'   => $lower_quartile,
            'Q2'   => self::median($numbers),
            'Q3'   => $upper_quartile,
            'percent100' => max($numbers),
            'IQR'  => $upper_quartile - $lower_quartile,
        ];
    }

    /**
     * Quartiles - Inclusive method (R method)
     */
    public static function quartilesInclusive(array $numbers): array
    {
        if (empty($numbers)) {
            throw new Exception('Cannot find the quartiles of an empty list of numbers');
        }

        sort($numbers);
        $length = count($numbers);

        if ($length % 2 == 0) {
            $lower_half = array_slice($numbers, 0, $length / 2);
            $upper_half = array_slice($numbers, $length / 2);
        } else {
            $lower_half = array_slice($numbers, 0, intdiv($length, 2));
            $upper_half = array_slice($numbers, intdiv($length, 2) + 1);

            // Add fucking median to both halves
            $median = self::median($numbers);
            array_push($lower_half, $median);
            array_unshift($upper_half, $median);
        }

        $lower_quartile = self::median($lower_half);
        $upper_quartile = self::median($upper_half);

        return [
            'percent0'   => min($numbers),
            'Q1'   => $lower_quartile,
            'Q2'   => self::median($numbers),
            'Q3'   => $upper_quartile,
            'percent100' => max($numbers),
            'IQR'  => $upper_quartile - $lower_quartile,
        ];
    }

    /**
     * IQR - Interquartile range (midspread, middle fifty)
     * A measure of statistical dispersion.
     */
    public static function interquartileRange(array $numbers, string $method = 'exclusive'): float
    {
        return self::quartiles($numbers, $method)['IQR'];
    }

    /**
     * Compute the P-th percentile of a list of numbers
     * Linear interpolation between closest ranks method
     * 
     * ν(x) = νₓ + x％1(νₓ₊₁ - νₓ)
     * 
     *      P
     * x - --- (N - 1) + 1
     *     100
     */
    public static function percentile(array $numbers, float $P): float
    {
        if (empty($numbers)) {
            throw new Exception('Cannot find the P-th percentile of an empty list of numbers');
        }
        if ($P < 0 || $P > 100) {
            throw new Exception('Percentile P must be between 0 and 100.');
        }

        $N = count($numbers);
        if ($N === 1) {
            return array_shift($numbers);
        }

        sort($numbers);

        if ($P == 100) {
            return  $numbers[$N - 1];
        }

        $x    = ($P / 100) * ($N - 1) + 1;
        $absX  = intval($x);
        $percentilX = $x - $absX;
        $νx   = $numbers[$absX - 1];
        $νx1 = $numbers[$absX];

        return $νx + $percentilX * ($νx1 - $νx);
    }

    /**
     * Midhinge = (first quartile, third quartile) / 2
     */
    public static function midhinge(array $numbers): float
    {
        $quartiles = self::quartiles($numbers);
        $Q1        = $quartiles['Q1'];
        $Q2        = $quartiles['Q3'];

        return self::mean([$Q1, $Q2]);
    }

    /**
     * Coefficient of variation (relative standard deviation)
     * 
     *      σ
     * cᵥ = -
     *      μ
     */
    public static function coefficientOfVariation(array $numbers): float
    {
        $σ = self::standardDeviation($numbers);
        $μ = self::mean($numbers);

        return $σ / $μ;
    }

    /**
     * Calculate the mean self of a list of numbers
     * 
     *     ∑(xᵢ)
     * x̄ = -----
     *       n
     */
    public static function mean(array $numbers): float
    {
        if (empty($numbers)) {
            throw new Exception('Cannot find the self of an empty list of numbers');
        }
        return array_sum($numbers) / count($numbers);
    }

    /**
     * Calculate the weighted mean self of a list of numbers
     * 
     *     ∑(xᵢwᵢ)
     * x̄ = -----
     *      ∑(wᵢ)
     */
    public static function weightedMean(array $numbers, array $weights): float
    {
        if (empty($numbers)) {
            throw new Exception('Cannot find the weightedMean of an empty list of numbers');
        }
        if (empty($weights)) {
            return self::mean($numbers);
        }
        if (count($numbers) !== count($weights)) {
            throw new Exception('Numbers and weights must have the same number of elements.');
        }

        $∑xw = array_sum(array_map(
            function ($xi, $wi) {
                return $xi * $wi;
            },
            $numbers,
            $weights
        ));
        $∑w = array_sum($weights);

        return $∑xw / $∑w;
    }

    /**
     * Calculate the median self of a list of numbers
     */
    public static function median(array $numbers): float
    {
        if (empty($numbers)) {
            throw new Exception('Cannot find the median of an empty list of numbers');
        }
        if (count($numbers) === 1) {
            return array_pop($numbers);
        }

        $numbers = array_values($numbers);

        // For odd number of numbers, take the middle indexed number
        if (count($numbers) % 2 == 1) {
            $middle_index = intdiv(count($numbers), 2);
            return self::kthSmallest($numbers, $middle_index);
        }

        // For even number of items, take the mean of the middle two indexed numbers
        $left_middle_index  = intdiv(count($numbers), 2) - 1;
        $left_median        = self::kthSmallest($numbers, $left_middle_index);
        $right_middle_index = $left_middle_index + 1;
        $right_median       = self::kthSmallest($numbers, $right_middle_index);

        return self::mean([$left_median, $right_median]);
    }

    /**
     * Return the kth smallest value in an array
     * Uses a linear-time algorithm: O(n) time in worst case.
     */
    public static function kthSmallest(array $numbers, int $k): float
    {
        $n = count($numbers);
        if ($n === 0) {
            throw new Exception('Cannot find the k-th smallest of an empty list of numbers');
        }
        if ($k >= $n) {
            throw new Exception('k cannot be greater than or equal to the count of numbers');
        }

        $numbers = array_values($numbers);

        if ($n <= 5) {
            sort($numbers);
            return $numbers[$k];
        }

        $num_slices = ceil($n / 5);
        $median_array = [];
        for ($i = 0; $i < $num_slices; $i++) {
            $median_array[] = self::median(array_slice($numbers, 5 * $i, 5));
        }

        $median_of_medians = self::median($median_array);

        $lower_upper   = self::splitAtValue($numbers, $median_of_medians);
        $lower_number = count($lower_upper['lower']);
        $equal_number = $lower_upper['equal'];

        if ($k < $lower_number) {
            return self::kthSmallest($lower_upper['lower'], $k);
        } elseif ($k < ($lower_number + $equal_number)) {
            return $median_of_medians;
        } else {
            return self::kthSmallest($lower_upper['upper'], $k - $lower_number - $equal_number);
        }
    }

    /**
     * Given an array and a value, separate the array into two groups,
     * those values which are greater than the value, and those that are less
     * than the value. Also, tell how many times the value appears in the array.
     */
    private static function splitAtValue(array $numbers, float $value): array
    {
        $lower        = [];
        $upper        = [];
        $number_equal = 0;

        foreach ($numbers as $number) {
            if ($number < $value) {
                $lower[] = $number;
            } elseif ($number > $value) {
                $upper[] = $number;
            } else {
                $number_equal++;
            }
        }

        return [
            'lower' => $lower,
            'upper' => $upper,
            'equal' => $number_equal,
        ];
    }

    /**
     * Calculate the mode self of a list of numbers
     */
    public static function mode(array $numbers): array
    {
        if (empty($numbers)) {
            throw new Exception('Cannot find the mode of an empty list of numbers');
        }

        $number_strings = array_map('strval', $numbers);
        $number_counts  = array_count_values($number_strings);
        $max            = max($number_counts);
        $modes          = array();
        foreach ($number_counts as $number => $count) {
            if ($count === $max) {
                $modes[] = $number;
            }
        }

        return array_map('floatval', $modes);
    }

    /**
     * n-th Central moment
     * 
     *      ∑(xᵢ - μ)ⁿ
     * μn = ----------
     *          N
     */
    public static function centralMoment(array $X, int $n): float
    {
        if (empty($X)) {
            throw new Exception('Cannot find the central moment of an empty list of numbers');
        }

        $μ         = self::mean($X);
        $∑xμ = array_sum(array_map(
            function ($xi) use ($μ, $n) {
                return pow(($xi - $μ), $n);
            },
            $X
        ));
        $N = count($X);

        return $∑xμ / $N;
    }

    /**
     * Population skewness
     * 
     *         μ₃
     * γ₁ = -------
     *       μ₂³′²
     */
    public static function populationSkewness(array $X): float
    {
        if (empty($X)) {
            throw new Exception('Cannot find the population skewness of an empty list of numbers');
        }

        $μ3 = self::centralMoment($X, 3);
        $μ2 = self::centralMoment($X, 2);
    
        $μ232 = pow($μ2, 3 / 2);
        if ($μ232 == 0) {
            return \NAN;  // Prevents division by zero in μ3 / μ232 equation
        }

        return ($μ3 /  $μ232);
    }

    /**
     * Sample skewness
     * 
     *         μ₃     √(n(n - 1))
     * γ₁ = ------- × -----------
     *       μ₂³′²       n - 2
     */
    public static function sampleSkewness(array $X): float
    {
        $n = count($X);
        if ($n < 3) {
            throw new Exception('Cannot find the sample skewness of less than three numbers');
        }

        $μ3    = self::centralMoment($X, 3);
        $μ2    = self::centralMoment($X, 2);

        $μ232 = pow($μ2, 3 / 2);
        if ($μ232 == 0) {
            return \NAN;  // Prevents division by zero in μ3 / μ232 equation
        }

        $√nn1 = sqrt($n * ($n - 1));

        return ($μ3 / $μ232) * ( $√nn1 / ($n - 2) );
    }

    /**
     * Skewness
     */
    public static function skewness(array $X, string $type = self::SAMPLE_SKEWNESS): float
    {
        switch ($type) {
            case self::SAMPLE_SKEWNESS:
                return self::sampleSkewness($X);

            case self::POPULATION_SKEWNESS:
                return self::populationSkewness($X);

            default:
                throw new Exception("Type $type is not a valid skewness algorithm type");
        }
    }

    /**
     * Standard Error of Skewness (SES)
     *
     *         _____________________
     *        /      6n(n - 1)
     * SES = / --------------------
     *      √  (n - 2)(n + 1)(n + 3)
     */
    public static function ses(int $n): float
    {
        if ($n < 3) {
            throw new Exception("SES requires a dataset of n > 2. N of $n given.");
        }

        $n6n1           = 6 * $n * ($n - 1);
        $n2n1n3 = ($n - 2) * ($n + 1) * ($n + 3);

        return sqrt($n6n1 / $n2n1n3);
    }

    /**
     * Sample Excess Kurtosis
     * 
     *       μ₄
     * γ₂ = ---- − 3
     *       μ₂²
     */
    public static function sampleKurtosis(array $X): float
    {
        if (empty($X)) {
            throw new Exception('Cannot find the kurtosis of an empty list of numbers');
        }

        $μ4  = self::centralMoment($X, 4);
        $μ2 = pow(self::centralMoment($X, 2), 2);

        if ($μ2 == 0) {
            return \NAN;
        }

        return ( $μ4 / $μ2 ) - 3;
    }

    /**
     * Population Excess Kurtosis
     *
     *                          (n - 1)
     * G₂ = [(n + 1) g₂ + 6] --------------
     *                       (n - 2)(n - 3)
     *
     *                                    μ₄
     * where g₂ is the sample kurtotis = ---- − 3
     *                                    μ₂²
     */
    public static function populationKurtosis(array $X): float
    {
        if (count($X) < 4) {
            throw new Exception('Cannot find the kurtosis of an empty list of numbers');
        }

        $g2 = self::sampleKurtosis($X);

        $n = count($X);
        $x = ($n + 1) * $g2 + 6;

        return ($x * ($n - 1)) / (($n - 2) * ($n - 3));
    }

    /**
     * Standard Error of Kurtosis (SEK)
     *
     *                ______________
     *               /    (n² - 1)
     * SEK = 2(SES) / --------------
     *             √  (n - 3)(n + 5)
     */
    public static function sek(int $n): float
    {
        if ($n < 4) {
            throw new Exception("SEK requires a dataset of n > 3. N of $n given.");
        }

        $SES2 = 2 * self::ses($n);
        $n1 = $n ** 2 - 1;
        $x = ($n - 3) * ($n + 5);

        return $SES2 * sqrt($n1 / $x);
    }

    /**
     * Standard error of the mean
     *       s
     * SEₓ = --
     *       √n
     */
    public static function standardErrorOfTheMean(array $X): float
    {
        if (empty($X)) {
            throw new Exception('Cannot find the SEM of an empty list of numbers');
        }

        $s  = self::standardDeviation($X, self::SAMPLE);
        $√n = sqrt(count($X));
        return $s / $√n;
    }

    /**
     * Sum of squares deviations
     *
     * ∑(xᵢ - μ)²
     */
    public static function sumOfSquaresDeviations(array $numbers): float
    {
        if (empty($numbers)) {
            throw new Exception('Cannot find the sum of squares deviations of an empty list of numbers');
        }

        $μ = self::mean($numbers);
        $x = array_sum(array_map(
            function ($xi) use ($μ) {
                return pow(($xi - $μ), 2);
            },
            $numbers
        ));

        return $x;
    }

    /**
     * Get a report of all the descriptive statistics over a list of numbers
     */
    public static function describe(array $numbers, bool $population = false): array
    {
        $n = count($numbers);
        $μ = self::mean($numbers);
        $σ = self::standardDeviation($numbers, $population);

        return [
            'n'                  => $n,
            'min'                => min($numbers),
            'max'                => max($numbers),
            'mean'               => $μ,
            'median'             => self::median($numbers),
            'mode'               => self::mode($numbers),
            'range'              => self::range($numbers),
            'midrange'           => self::midrange($numbers),
            'variance'           => $population ? self::populationVariance($numbers) : self::sampleVariance($numbers),
            'sd'                 => $σ,
            'cv'                 => $μ ? $σ / $μ : \NAN,
            'mean_mad'           => self::meanAbsoluteDeviation($numbers),
            'median_mad'         => self::medianAbsoluteDeviation($numbers),
            'quartiles'          => self::quartiles($numbers),
            'midhinge'           => self::midhinge($numbers),
            'skewness'           => $population
                ? ($n > 0 ? self::populationSkewness($numbers) : null)
                : ($n >= 3 ? self::skewness($numbers) : null),
            'ses'                => $n > 2 ? self::ses($n) : null,
            'kurtosis'           => $population
                ? ($n > 3 ? self::populationKurtosis($numbers) : null)
                : ($n > 0 ? self::sampleKurtosis($numbers) : null),
            'sek'                => $n > 3 ? self::sek($n) : null,
            'sem'                => self::standardErrorOfTheMean($numbers)
        ];
    }

    /**
     * Five number summary
     */
    public static function fiveNumberSummary(array $numbers): array
    {
        $quartiles = self::quartiles($numbers);

        return [
            'min'    => min($numbers),
            'Q1'     => $quartiles['Q1'],
            'median' => self::median($numbers),
            'Q3'     => $quartiles['Q3'],
            'max'    => max($numbers),
        ];
    }
}