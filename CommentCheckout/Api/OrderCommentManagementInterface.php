<?php
namespace Web\CommentCheckout\Api;

/**
 * Interface for saving the checkout comment to the quote for orders of logged in users
 * @api
 */
interface OrderCommentManagementInterface
{
    /**
     * @param int $cartId
     * @param \Web\CommentCheckout\Api\Data\OrderCommentInterface $orderComment
     * @return string
     */
    public function saveOrderComment(
        $cartId,
        \Web\CommentCheckout\Api\Data\OrderCommentInterface $orderComment
    );
}
