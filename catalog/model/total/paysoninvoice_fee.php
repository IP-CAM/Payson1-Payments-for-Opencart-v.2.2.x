<?php

class ModelTotalPaysoninvoiceFee extends Model {
    
    public function getTotal($total) {

        if (isset($this->session->data['payment_method']['code']) && $this->session->data['payment_method']['code'] == 'paysoninvoice' && $this->config->get('paysoninvoice_fee_fee') >= 0 && $this->session->data['payment_method']['code'] != 'paysondirect') {
            $this->load->language('total/paysoninvoice_fee');
            $total['totals'][] = array(
                'code' => 'paysoninvoice_fee',
                'title' => $this->language->get('text_paysoninvoice_fee'),
                'text' => $this->currency->format($this->config->get('paysoninvoice_fee_fee')),
                'value' => $this->config->get('paysoninvoice_fee_fee'),
                    // 'sort_order' => $this->config->get('paysoninvoice_fee_sort_order')
            );

            if ($this->config->get('paysoninvoice_fee_tax_class_id')) {
                $tax_rates = $this->tax->getRates($this->config->get('paysoninvoice_fee_fee'), $this->config->get('paysoninvoice_fee_tax_class_id'));

                foreach ($tax_rates as $tax_rate) {
                    if (!isset($total['taxes'][$tax_rate['tax_rate_id']])) {
                        $total['taxes'][$tax_rate['tax_rate_id']] = $tax_rate['amount'];
                    } else {
                        $total['taxes'][$tax_rate['tax_rate_id']] += $tax_rate['amount'];
                    }
                }
            }
            $total += $this->config->get('paysoninvoice_fee_fee');
        }
    }
    
}

?>