<?php
class ModelPaymentBankBNI extends Model {
    public function getMethod($address, $total) {
        $this->load->language('payment/bank_bni');

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('bank_bni_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

        if ($this->config->get('bank_bni_total') > 0 && $this->config->get('bank_bni_total') > $total) {
            $status = false;
        } elseif (!$this->config->get('bank_bni_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }

        $method_data = array();

        if ($status) {
            $method_data = array(
                'code'       => 'bank_bni',
                'title'      => $this->language->get('text_title'),
                'terms'      => $this->config->get('bank_bni_term_' . $this->config->get('config_language_id')),
                'sort_order' => $this->config->get('bank_bni_sort_order')
            );
        }

        return $method_data;
    }
}