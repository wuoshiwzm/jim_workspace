// AvlTree class
//
// CONSTRUCTION: with no initializer
//
// ******************PUBLIC OPERATIONS*********************
// void insert( x )       --> Insert x
// void remove( x )       --> Remove x (unimplemented)
// boolean contains( x )  --> Return true if x is present
// boolean remove( x )    --> Return true if x was present
// Comparable findMin( )  --> Return smallest item
// Comparable findMax( )  --> Return largest item
// boolean isEmpty( )     --> Return true if empty; else false
// void makeEmpty( )      --> Remove all items
// void printTree( )      --> Print tree in sorted order
// ******************ERRORS********************************
// Throws UnderflowException as appropriate

/**
 * Implements an AVL tree.
 * Note that all "matching" is based on the compareTo method.
 * @author Mark Allen Weiss
 */

package testjava;

public class AvlTree<AnyType extends Comparable<? super AnyType>> {
	private AvlNode<AnyType> root;

	public AvlTree() {
		root = null;
	}

	public void insert(AnyType x) {
		root = insert(x, root);
	}

	public void remove(AnyType x) {
		root = remove(x, root);
	}

	private int height(AvlNode<AnyType> t) {
		return t == null ? -1 : t.height;
	}

	private AvlNode<AnyType> insert(AnyType x, AvlNode<AnyType> t) {
		if (t == null)
			return new AvlNode<>(x, null, null);

		int compareResult = x.compareTo(t.element);

		if (compareResult < 0)
			t.left = insert(x, t.left);
		else if (compareResult > 0)
			t.right = insert(x, t.right);
		else
			;
		return balance(t);
	}

	private static final int ALLOWED_IMBALANCE = 1;

	private AvlNode<AnyType> balance(AvlNode<AnyType> t){
		if(t == null)
			return t;
		
		if(height(t.left) - height(t.right)>ALLOWED_IMBALANCE)
			if(height(t.left.left) >= height(t.left.right))
				t=rotateWithLeftChild(t);
			else
				t = doubleWithLeftChild(t);
		else
			if(height(t.right) - height(t.left)>ALLOWED_IMBALANCE)
				if(height(t.right.right)>=height(t.right.left))
					t = rotateWithRightChild(t);
				else
					t = doubleWithRightChild(t);
		t.height = Math.max(height(t.left), height(t.right)+1)
		return t;
	}
	
	private AvlNode<AnyType> rotateWithLeftChild(AvlNode<AnyType> k2){
		AvlNode<AnyType> k1 = k2.left;
		k2.left = k1.right;
		k1.right = k2;
		k2.height = Math.max(height(k2.left), height(k2.right))+1;
		k1.height = Math.max(height(k1.left), k2.height);
		return k1;
	}
	
	private AvlNode<AnyType> doubleWithLeftChild(AvlNode<AnyType> k3){
		k3.left = doubleWithRightChild(k3.left);
		return rotateWithLeftChild(k3);
	}
	
	
	
	
	
	
	private AvlNode<AnyType> remove(AnyType x, AvlNode<AnyType> t) {
		if (t == null)
			return t;

		int compareResult = x.compareTo(t.element);

		if (compareResult < 0) {
			t.left = remove(x, t.left);
		} else if (compareResult > 0) {
			t.right = remove(x, t.right);
		} else if (t.left != null && t.right != null) {
			t.element = findMin(t.right).element;
			t.right = remove(t.element, t.right);
		} else {
			t = (t.left != null) ? t.left : t.right;
		}
		return balance(t);
	}

	private static class AvlNode<AnyType> {
		AvlNode(AnyType theElement) {
			this(theElement, null, null);
		}

		AvlNode(AnyType theElement, AvlNode<AnyType> lt, AvlNode<AnyType> rt) {
			element = theElement;
			left = lt;
			right = rt;
			height = 0;
		}

		AnyType element;
		AvlNode<AnyType> left;
		AvlNode<AnyType> right;
		int height;
	}

}